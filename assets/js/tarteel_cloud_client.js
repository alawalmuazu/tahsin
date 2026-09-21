"use strict";
(() => {
  // src/lib/tarteel/tarteelCloudClient.ts
  var TARTEEL_DEFAULT_TOKEN = "906523fd5634c7177dd6cd346ae7457286e3d50f";
  var TARTEEL_DEFAULT_USER_ID = "16687612";
  var TARTEEL_DEFAULT_ENDPOINT = "wss://voice-v2.tarteel.io";
  function resampleTo16k(input, inputSampleRate) {
    if (inputSampleRate === 16e3) return input;
    const ratio = inputSampleRate / 16e3;
    const newLength = Math.round(input.length / ratio);
    const result = new Float32Array(newLength);
    for (let i = 0; i < newLength; i++) {
      const originIdx = i * ratio;
      const leftIdx = Math.floor(originIdx);
      const rightIdx = Math.min(leftIdx + 1, input.length - 1);
      const frac = originIdx - leftIdx;
      result[i] = input[leftIdx] * (1 - frac) + input[rightIdx] * frac;
    }
    return result;
  }
  function floatTo16BitPCM(floatSamples) {
    const pcm = new Int16Array(floatSamples.length);
    for (let i = 0; i < floatSamples.length; i++) {
      const s = Math.max(-1, Math.min(1, floatSamples[i]));
      pcm[i] = s < 0 ? s * 32768 : s * 32767;
    }
    return pcm;
  }
  function pcmToWavBlob(pcmChunks, sampleRate = 16e3) {
    let totalSamples = 0;
    for (const chunk of pcmChunks) {
      totalSamples += chunk.length;
    }
    const byteRate = sampleRate * 2;
    const blockAlign = 2;
    const dataSize = totalSamples * 2;
    const buffer = new ArrayBuffer(44 + dataSize);
    const view = new DataView(buffer);
    writeString(view, 0, "RIFF");
    view.setUint32(4, 36 + dataSize, true);
    writeString(view, 8, "WAVE");
    writeString(view, 12, "fmt ");
    view.setUint32(16, 16, true);
    view.setUint16(20, 1, true);
    view.setUint16(22, 1, true);
    view.setUint32(24, sampleRate, true);
    view.setUint32(28, byteRate, true);
    view.setUint16(32, blockAlign, true);
    view.setUint16(34, 16, true);
    writeString(view, 36, "data");
    view.setUint32(40, dataSize, true);
    let offset = 44;
    for (const chunk of pcmChunks) {
      for (let i = 0; i < chunk.length; i++) {
        view.setInt16(offset, chunk[i], true);
        offset += 2;
      }
    }
    return new Blob([buffer], { type: "audio/wav" });
  }
  function writeString(view, offset, string) {
    for (let i = 0; i < string.length; i++) {
      view.setUint8(offset + i, string.charCodeAt(i));
    }
  }
  var TarteelCloudClient = class {
    constructor(config, callbacks) {
      this.ws = null;
      this.mediaStream = null;
      this.audioContext = null;
      this.scriptProcessor = null;
      this.sourceNode = null;
      this.pcmChunkAccumulator = [];
      this.recordedPcmChunks = [];
      this.accumulatedTranscript = "";
      this.accumulatedStates = [];
      this.accumulatedMistakes = /* @__PURE__ */ new Map();
      this.status = "idle";
      this.startTime = 0;
      this.sessionId = "";
      this.sessionGroupId = "";
      this.debug = true;
      this.audioFramesSent = 0;
      this.inboundEventCounts = {};
      this.lastPartialLogAt = 0;
      var _a, _b, _c;
      this.config = {
        endpoint: (config == null ? void 0 : config.endpoint) || TARTEEL_DEFAULT_ENDPOINT,
        authToken: (config == null ? void 0 : config.authToken) || TARTEEL_DEFAULT_TOKEN,
        userId: (config == null ? void 0 : config.userId) || TARTEEL_DEFAULT_USER_ID,
        appVersion: (config == null ? void 0 : config.appVersion) || "5.32.0",
        devicePlatform: (config == null ? void 0 : config.devicePlatform) || "web",
        surahNumber: (config == null ? void 0 : config.surahNumber) || 1,
        fromAyah: (config == null ? void 0 : config.fromAyah) || 1,
        toAyah: (config == null ? void 0 : config.toAyah) || 7,
        wordNumber: (config == null ? void 0 : config.wordNumber) || 1,
        recitationMode: (config == null ? void 0 : config.recitationMode) || "follow",
        isDiacritized: (_a = config == null ? void 0 : config.isDiacritized) != null ? _a : true,
        isDualModel: (_b = config == null ? void 0 : config.isDualModel) != null ? _b : true,
        bufferSize: (config == null ? void 0 : config.bufferSize) || 2048,
        sampleRate: (config == null ? void 0 : config.sampleRate) || 16e3,
        debug: (_c = config == null ? void 0 : config.debug) != null ? _c : true
      };
      this.debug = this.config.debug;
      this.callbacks = callbacks || {};
    }
    log(...args) {
      if (!this.debug) return;
      console.log("%c[TarteelCloud]", "color:#38bdf8;font-weight:700", ...args);
    }
    logWarn(...args) {
      if (!this.debug) return;
      console.warn("%c[TarteelCloud]", "color:#fbbf24;font-weight:700", ...args);
    }
    logGroup(title, payload) {
      if (!this.debug) return;
      console.groupCollapsed(`%c[TarteelCloud] ${title}`, "color:#a78bfa;font-weight:700");
      console.log(payload);
      console.groupEnd();
    }
    redactAuth(data) {
      const clone = { ...data };
      if (typeof clone.authToken === "string" && clone.authToken.length > 8) {
        clone.authToken = `${clone.authToken.slice(0, 4)}\u2026${clone.authToken.slice(-4)}`;
      }
      return clone;
    }
    setCallbacks(callbacks) {
      this.callbacks = { ...this.callbacks, ...callbacks };
    }
    updateConfig(config) {
      this.config = { ...this.config, ...config };
    }
    getStatus() {
      return this.status;
    }
    setStatus(status) {
      var _a, _b;
      this.status = status;
      (_b = (_a = this.callbacks).onStatusChange) == null ? void 0 : _b.call(_a, status);
    }
    /**
     * Start live recitation stream to Tarteel Cloud Voice Engine
     */
    async start(options) {
      var _a, _b;
      if (this.status === "recording" || this.status === "connecting") {
        console.warn("TarteelCloudClient is already running or connecting.");
        return;
      }
      if (options) {
        if (options.surahNumber !== void 0) this.config.surahNumber = options.surahNumber;
        if (options.fromAyah !== void 0) this.config.fromAyah = options.fromAyah;
        if (options.toAyah !== void 0) this.config.toAyah = options.toAyah;
        if (options.wordNumber !== void 0) this.config.wordNumber = options.wordNumber;
        if (options.recitationMode !== void 0) this.config.recitationMode = options.recitationMode;
      }
      this.setStatus("connecting");
      this.pcmChunkAccumulator = [];
      this.recordedPcmChunks = [];
      this.accumulatedTranscript = "";
      this.accumulatedStates = [];
      this.accumulatedMistakes.clear();
      this.startTime = Date.now();
      this.audioFramesSent = 0;
      this.inboundEventCounts = {};
      this.lastPartialLogAt = 0;
      this.sessionId = this.generateUUID();
      this.sessionGroupId = this.generateUUID();
      this.log("\u25B6 Starting session", {
        endpoint: this.config.endpoint,
        sessionId: this.sessionId,
        sessionGroupId: this.sessionGroupId,
        range: {
          surah: this.config.surahNumber,
          fromAyah: this.config.fromAyah,
          toAyah: this.config.toAyah,
          wordNumber: this.config.wordNumber
        },
        flags: {
          isDualModel: this.config.isDualModel,
          isDiacritized: this.config.isDiacritized,
          recitationMode: this.config.recitationMode
        },
        note: "Cloud stack (public): NeMo fine-tune \u2192 Riva streaming ASR \u2192 Triton. Dual-model/tajweed is server-side; watch STATES_UPDATE.mistakeUpdates."
      });
      try {
        this.mediaStream = await navigator.mediaDevices.getUserMedia({
          audio: {
            echoCancellation: true,
            noiseSuppression: true,
            autoGainControl: true
          }
        });
        this.log("\u{1F3A4} Microphone acquired", {
          tracks: this.mediaStream.getAudioTracks().map((t) => {
            var _a2;
            return {
              label: t.label,
              settings: (_a2 = t.getSettings) == null ? void 0 : _a2.call(t)
            };
          })
        });
        await this.initWebSocket();
        this.initAudioPipeline();
        this.setStatus("recording");
        this.log("\u25CF Recording \u2014 streaming LINEAR16 @ 16kHz mono to cloud");
      } catch (err) {
        this.setStatus("error");
        this.cleanup();
        const errorMsg = (err == null ? void 0 : err.message) || String(err);
        (_b = (_a = this.callbacks).onError) == null ? void 0 : _b.call(_a, errorMsg);
        throw err;
      }
    }
    initWebSocket() {
      return new Promise((resolve, reject) => {
        let settled = false;
        const finish = (fn) => {
          if (settled) return;
          settled = true;
          clearTimeout(timer);
          fn();
        };
        const timer = setTimeout(() => {
          finish(() => {
            var _a;
            try {
              (_a = this.ws) == null ? void 0 : _a.close();
            } catch (e) {
            }
            reject(new Error("WebSocket connection timed out."));
          });
        }, 8e3);
        try {
          this.log("\u{1F50C} Connecting WebSocket\u2026", this.config.endpoint);
          this.ws = new WebSocket(this.config.endpoint);
          this.ws.binaryType = "arraybuffer";
          this.ws.onopen = () => {
            finish(() => {
              var _a, _b;
              this.log("\u2705 WebSocket OPEN", {
                url: this.config.endpoint,
                protocol: ((_a = this.ws) == null ? void 0 : _a.protocol) || "(none)",
                readyState: (_b = this.ws) == null ? void 0 : _b.readyState
              });
              this.sendStartStream();
              resolve();
            });
          };
          this.ws.onmessage = (event) => {
            this.handleServerMessage(event);
          };
          this.ws.onerror = (evt) => {
            console.error("%c[TarteelCloud] WebSocket ERROR", "color:#f43f5e;font-weight:700", evt);
            finish(() => {
              var _a, _b;
              (_b = (_a = this.callbacks).onError) == null ? void 0 : _b.call(_a, "WebSocket connection to Tarteel engine failed.");
              reject(new Error("WebSocket connection to Tarteel engine failed."));
            });
          };
          this.ws.onclose = (event) => {
            this.log("\u23F9 WebSocket CLOSE", {
              code: event.code,
              reason: event.reason || "(none)",
              wasClean: event.wasClean,
              inboundEventCounts: { ...this.inboundEventCounts },
              audioFramesSent: this.audioFramesSent,
              statesMatched: this.accumulatedStates.length,
              mistakes: this.accumulatedMistakes.size
            });
            if (!settled) {
              finish(
                () => reject(
                  new Error(
                    event.reason || `WebSocket closed before open (code ${event.code})`
                  )
                )
              );
              return;
            }
            if (this.status === "recording" || this.status === "connecting") {
              this.setStatus("idle");
            }
          };
        } catch (e) {
          finish(() => reject(e));
        }
      });
    }
    sendStartStream() {
      if (!this.ws || this.ws.readyState !== WebSocket.OPEN) return;
      const startPayload = {
        event: "START_STREAM",
        data: {
          appVersion: this.config.appVersion,
          audioConfig: {
            bufferSize: this.config.bufferSize,
            sampleRate: this.config.sampleRate,
            bitsPerChannel: 16,
            channelsPerFrame: 1
          },
          sttConfig: {
            fileFormat: "LINEAR16",
            channels: 1,
            sampleRate: this.config.sampleRate,
            modelName: "",
            languageCode: "ar",
            enableInterimResults: true,
            enableWordTimeOffsets: true,
            maxAlternatives: 1
          },
          authToken: this.config.authToken,
          deviceId: this.generateUUID(),
          devicePlatform: this.config.devicePlatform,
          isMemorization: this.config.recitationMode === "memorization",
          isDiacritized: this.config.isDiacritized,
          isDualModel: this.config.isDualModel,
          isInitialTargetRangeStrict: false,
          isStartPositionStrict: false,
          startPosition: {
            surahNumber: this.config.surahNumber,
            ayahNumber: this.config.fromAyah,
            wordNumber: this.config.wordNumber
          },
          endPosition: {
            surahNumber: this.config.surahNumber,
            ayahNumber: this.config.toAyah,
            wordNumber: 1
          },
          recitationMode: this.config.recitationMode,
          sessionId: this.sessionId,
          sessionGroupId: this.sessionGroupId,
          shouldCollectAudio: false,
          shouldLabelAudio: false,
          userId: this.config.userId
        }
      };
      this.logGroup("\u2B06 OUTBOUND START_STREAM (tells cloud where to lock + which engines)", {
        event: startPayload.event,
        data: this.redactAuth(startPayload.data),
        insight: {
          isDualModel: "When true, server runs a second pass for diacritics/tajweed (INCORRECT_TASHKEEL etc.). You cannot download this model \u2014 observe via mistakeUpdates.",
          isDiacritized: "Prefer Uthmani/harakat-aware decoding in the ASR hypothesis.",
          sttConfig: "Riva-style streaming ASR options (interim results + word time offsets).",
          startPosition: "Soft lock for karaoke cursor; aligner advances wordNumber as you recite."
        }
      });
      this.ws.send(JSON.stringify(startPayload));
    }
    initAudioPipeline() {
      if (!this.mediaStream) return;
      const AudioContextClass = window.AudioContext || window.webkitAudioContext;
      this.audioContext = new AudioContextClass();
      const source = this.audioContext.createMediaStreamSource(this.mediaStream);
      this.sourceNode = source;
      const scriptProcessor = this.audioContext.createScriptProcessor(4096, 1, 1);
      this.scriptProcessor = scriptProcessor;
      const gainNode = this.audioContext.createGain();
      gainNode.gain.value = 0;
      scriptProcessor.onaudioprocess = (audioProcessingEvent) => {
        var _a, _b, _c;
        if (this.status !== "recording") return;
        const inputChannelData = audioProcessingEvent.inputBuffer.getChannelData(0);
        let sumSquares = 0;
        for (let i = 0; i < inputChannelData.length; i++) {
          sumSquares += inputChannelData[i] * inputChannelData[i];
        }
        const rms = Math.sqrt(sumSquares / inputChannelData.length);
        const volumePercent = Math.min(100, Math.round(rms * 400));
        (_b = (_a = this.callbacks).onAudioVolume) == null ? void 0 : _b.call(_a, volumePercent);
        const currentRate = ((_c = this.audioContext) == null ? void 0 : _c.sampleRate) || 48e3;
        const resampled16k = resampleTo16k(inputChannelData, currentRate);
        const pcm16 = floatTo16BitPCM(resampled16k);
        this.recordedPcmChunks.push(pcm16);
        for (let i = 0; i < pcm16.length; i++) {
          this.pcmChunkAccumulator.push(pcm16[i]);
        }
        while (this.pcmChunkAccumulator.length >= 1024) {
          const frameSamples = this.pcmChunkAccumulator.splice(0, 1024);
          const frameInt16 = new Int16Array(frameSamples);
          if (this.ws && this.ws.readyState === WebSocket.OPEN) {
            this.ws.send(frameInt16.buffer);
            this.audioFramesSent += 1;
            if (this.audioFramesSent === 1 || this.audioFramesSent % 25 === 0) {
              this.log("\u2B06 PCM frame \u2192 cloud", {
                frame: this.audioFramesSent,
                bytes: frameInt16.byteLength,
                approxAudioMs: Math.round(this.audioFramesSent * 1024 / 16),
                volumePercent
              });
            }
          }
        }
      };
      source.connect(scriptProcessor);
      scriptProcessor.connect(gainNode);
      gainNode.connect(this.audioContext.destination);
    }
    handleServerMessage(event) {
      var _a, _b, _c, _d, _e, _f, _g, _h, _i;
      if (typeof event.data !== "string") {
        const size = event.data instanceof ArrayBuffer ? event.data.byteLength : event.data instanceof Blob ? event.data.size : "?";
        this.logWarn("\u2B07 Binary inbound (unexpected for voice-v2 JSON protocol)", {
          type: Object.prototype.toString.call(event.data),
          size
        });
        return;
      }
      try {
        const raw = event.data;
        const msg = JSON.parse(raw);
        const eventType = msg.event || msg.type || "UNKNOWN";
        const data = (_a = msg.data) != null ? _a : msg;
        this.inboundEventCounts[eventType] = (this.inboundEventCounts[eventType] || 0) + 1;
        if (eventType !== "PARTIAL_TRANSCRIPT" && eventType !== "STATES_UPDATE") {
          this.logGroup(`\u2B07 INBOUND ${eventType} (raw cloud event #${this.inboundEventCounts[eventType]})`, {
            msg,
            rawPreview: raw.length > 2e3 ? `${raw.slice(0, 2e3)}\u2026` : raw
          });
        }
        if (eventType === "PARTIAL_TRANSCRIPT" && data) {
          const text = data.queryText || data.transcript || data.text || "";
          this.accumulatedTranscript = text;
          const now = Date.now();
          if (now - this.lastPartialLogAt > 500 || text.length < 40) {
            this.lastPartialLogAt = now;
            this.log("\u2B07 PARTIAL_TRANSCRIPT (ASR hypothesis from NeMo/Riva)", {
              queryText: text,
              keys: Object.keys(data),
              fullData: data
            });
          }
          (_c = (_b = this.callbacks).onPartialTranscript) == null ? void 0 : _c.call(_b, text);
        } else if (eventType === "STATES_UPDATE" && data) {
          const newStates = data.newStates || [];
          const mistakeUpdates = data.mistakeUpdates || {};
          const mistakeKeys = Object.keys(mistakeUpdates || {});
          this.logGroup(
            `\u2B07 STATES_UPDATE \xB7 words=${newStates.length} mistakes=${mistakeKeys.length} isLost=${Boolean(
              data.isLost
            )}`,
            {
              audioProcessedMs: data.audioProcessedMs,
              stateIndexOffset: data.stateIndexOffset,
              isLost: Boolean(data.isLost),
              // Karaoke cursor from cloud aligner
              positions: newStates.map((st) => ({
                type: st.type,
                word: st.word,
                t: [st.startTime, st.endTime],
                pos: st.position ? `${st.position.surahNumber}:${st.position.ayahNumber}:${st.position.wordNumber}` : null,
                raw: st
              })),
              // Dual-model / tajweed channel
              mistakes: mistakeKeys.map((id) => {
                const m = mistakeUpdates[id];
                return {
                  id: m.id || id,
                  mistakeType: m.mistakeType,
                  expected: m.expectedTranscript,
                  received: m.receivedTranscript,
                  positions: m.positions,
                  ayah: m.ayah,
                  timesMs: [m.startTimeMs, m.endTimeMs],
                  raw: m
                };
              }),
              // Dump every top-level key so new cloud fields are visible
              allDataKeys: Object.keys(data),
              rawData: data
            }
          );
          if (newStates.length > 0) {
            this.accumulatedStates.push(...newStates);
            for (const st of newStates) {
              (_e = (_d = this.callbacks).onWordMatched) == null ? void 0 : _e.call(_d, st);
            }
          }
          if (mistakeUpdates) {
            for (const key of Object.keys(mistakeUpdates)) {
              const m = mistakeUpdates[key];
              this.accumulatedMistakes.set(m.id || key, m);
              (_g = (_f = this.callbacks).onMistakeDetected) == null ? void 0 : _g.call(_f, m);
              this.logWarn("\u26A0 Dual-model / tajweed mistake", {
                mistakeType: m.mistakeType,
                expected: m.expectedTranscript,
                received: m.receivedTranscript,
                positions: m.positions
              });
            }
          }
          (_i = (_h = this.callbacks).onStatesUpdate) == null ? void 0 : _i.call(_h, {
            isLost: Boolean(data.isLost),
            stateIndexOffset: data.stateIndexOffset,
            newStates,
            mistakeUpdates,
            audioProcessedMs: data.audioProcessedMs
          });
        }
      } catch (e) {
        this.logWarn("Error parsing Tarteel server message:", e, event.data);
      }
    }
    /**
     * Stop recitation, flush stream, cleanly close connections, and return full telemetry & audio WAV
     */
    async stop() {
      this.setStatus("stopping");
      if (this.pcmChunkAccumulator.length > 0) {
        const remainingInt16 = new Int16Array(this.pcmChunkAccumulator);
        if (this.ws && this.ws.readyState === WebSocket.OPEN) {
          this.ws.send(remainingInt16.buffer);
        }
        this.pcmChunkAccumulator = [];
      }
      if (this.ws && this.ws.readyState === WebSocket.OPEN) {
        try {
          this.log("\u2B06 OUTBOUND END_STREAM");
          this.ws.send(JSON.stringify({ event: "END_STREAM" }));
        } catch (_) {
        }
      }
      await new Promise((resolve) => setTimeout(resolve, 350));
      const audioBlob = pcmToWavBlob(this.recordedPcmChunks, 16e3);
      const audioUrl = URL.createObjectURL(audioBlob);
      const durationSec = Math.round((Date.now() - this.startTime) / 1e3);
      const summary = {
        audioBlob,
        audioUrl,
        durationSec,
        transcript: this.accumulatedTranscript,
        allStates: [...this.accumulatedStates],
        allMistakes: Array.from(this.accumulatedMistakes.values())
      };
      this.logGroup("\u25A0 SESSION SUMMARY (what cloud returned)", {
        durationSec,
        audioFramesSent: this.audioFramesSent,
        inboundEventCounts: { ...this.inboundEventCounts },
        transcript: summary.transcript,
        stateCount: summary.allStates.length,
        lastPositions: summary.allStates.slice(-8).map((s) => ({
          word: s.word,
          pos: s.position,
          type: s.type
        })),
        mistakes: summary.allMistakes,
        mistakeTypes: summary.allMistakes.reduce((acc, m) => {
          acc[m.mistakeType] = (acc[m.mistakeType] || 0) + 1;
          return acc;
        }, {})
      });
      this.cleanup();
      this.setStatus("idle");
      return summary;
    }
    /**
     * Abort immediately without waiting for server response
     */
    abort() {
      this.cleanup();
      this.setStatus("idle");
    }
    cleanup() {
      if (this.mediaStream) {
        this.mediaStream.getTracks().forEach((track) => track.stop());
        this.mediaStream = null;
      }
      if (this.scriptProcessor) {
        this.scriptProcessor.disconnect();
        this.scriptProcessor = null;
      }
      if (this.sourceNode) {
        this.sourceNode.disconnect();
        this.sourceNode = null;
      }
      if (this.audioContext && this.audioContext.state !== "closed") {
        this.audioContext.close().catch(() => {
        });
        this.audioContext = null;
      }
      if (this.ws) {
        this.ws.onopen = null;
        this.ws.onmessage = null;
        this.ws.onerror = null;
        this.ws.onclose = null;
        if (this.ws.readyState === WebSocket.OPEN || this.ws.readyState === WebSocket.CONNECTING) {
          try {
            this.ws.close();
          } catch (_) {
          }
        }
        this.ws = null;
      }
    }
    generateUUID() {
      if (typeof crypto !== "undefined" && crypto.randomUUID) {
        return crypto.randomUUID();
      }
      return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, (c) => {
        const r = Math.random() * 16 | 0;
        const v = c === "x" ? r : r & 3 | 8;
        return v.toString(16);
      });
    }
  };

  // scripts/bundle-tarteel-for-tahsin.mjs
  var DEFAULTS = {
    engine: "auto",
    wsUrl: TARTEEL_DEFAULT_ENDPOINT,
    authToken: TARTEEL_DEFAULT_TOKEN,
    userId: TARTEEL_DEFAULT_USER_ID,
    localWs: "ws://127.0.0.1:8001/v1/recite/stream",
    localHealth: "http://127.0.0.1:8001/health",
    isDualModel: true,
    isDiacritized: true,
    debug: true,
    appVersion: "5.32.0"
  };
  function readConfig() {
    const cfg = window.TARTEEL_CONFIG || {};
    return {
      engine: String(cfg.engine || DEFAULTS.engine).toLowerCase(),
      wsUrl: cfg.wsUrl || DEFAULTS.wsUrl,
      authToken: cfg.authToken || DEFAULTS.authToken,
      userId: cfg.userId || DEFAULTS.userId,
      localWs: cfg.localWs || DEFAULTS.localWs,
      localHealth: cfg.localHealth || DEFAULTS.localHealth,
      isDualModel: cfg.isDualModel !== false,
      isDiacritized: cfg.isDiacritized !== false,
      debug: cfg.debug !== false,
      appVersion: cfg.appVersion || DEFAULTS.appVersion
    };
  }
  function probeWebSocket(url, timeoutMs = 2500) {
    return new Promise((resolve) => {
      let settled = false;
      let ws = null;
      const done = (ok) => {
        if (settled) return;
        settled = true;
        clearTimeout(timer);
        try {
          ws && ws.close();
        } catch (e) {
        }
        resolve(ok);
      };
      const timer = setTimeout(() => done(false), timeoutMs);
      try {
        ws = new WebSocket(url);
        ws.onopen = () => done(true);
        ws.onerror = () => done(false);
        ws.onclose = () => done(false);
      } catch (e) {
        done(false);
      }
    });
  }
  async function probeLocalHealth(healthUrl, timeoutMs = 1500) {
    try {
      const ctrl = new AbortController();
      const t = setTimeout(() => ctrl.abort(), timeoutMs);
      const res = await fetch(healthUrl, { signal: ctrl.signal });
      clearTimeout(t);
      if (!res.ok) return { ok: false, body: null };
      const body = await res.json().catch(() => null);
      return { ok: !!(body && body.status === "ok"), body };
    } catch (e) {
      return { ok: false, body: null };
    }
  }
  async function resolveEngine(preferred) {
    const cfg = readConfig();
    const mode = (preferred || cfg.engine || "auto").toLowerCase();
    if (mode === "local") return "local";
    if (mode === "cloud") return "cloud";
    const cloudOk = await probeWebSocket(cfg.wsUrl);
    if (cloudOk) {
      console.log("%c[TarteelEngine] auto \u2192 cloud", "color:#38bdf8;font-weight:700", cfg.wsUrl);
      return "cloud";
    }
    const health = await probeLocalHealth(cfg.localHealth);
    if (health.ok || await probeWebSocket(cfg.localWs)) {
      console.log(
        "%c[TarteelEngine] cloud unavailable \u2192 local fallback",
        "color:#34d399;font-weight:700",
        cfg.localWs,
        health.body || ""
      );
      return "local";
    }
    console.warn(
      "%c[TarteelEngine] cloud down and local :8001 unreachable \u2014 still trying cloud start",
      "color:#fbbf24;font-weight:700"
    );
    return "cloud";
  }
  function buildClient(engine, config, callbacks) {
    const cfg = readConfig();
    const isLocal = engine === "local";
    const endpoint = isLocal ? cfg.localWs : cfg.wsUrl;
    console.log(`%c[TarteelEngine] mode=${engine}`, "color:#34d399;font-weight:700", endpoint);
    return new TarteelCloudClient(
      {
        ...config || {},
        endpoint,
        authToken: isLocal ? "local-dev" : cfg.authToken,
        userId: isLocal ? "local-user" : cfg.userId,
        appVersion: cfg.appVersion,
        isDualModel: cfg.isDualModel,
        isDiacritized: cfg.isDiacritized,
        debug: cfg.debug
      },
      callbacks || {}
    );
  }
  async function createTarteelClientAsync(config, callbacks) {
    const engine = await resolveEngine();
    return { client: buildClient(engine, config, callbacks), engine };
  }
  async function probeEngines() {
    const cfg = readConfig();
    const [cloudOk, health] = await Promise.all([
      probeWebSocket(cfg.wsUrl, 2e3),
      probeLocalHealth(cfg.localHealth, 1200)
    ]);
    let localOk = health.ok;
    if (!localOk) localOk = await probeWebSocket(cfg.localWs, 1500);
    return {
      cloud: cloudOk,
      local: localOk,
      localMeta: health.body,
      preferred: cfg.engine,
      tokenPreview: cfg.authToken && cfg.authToken.length > 8 ? `${cfg.authToken.slice(0, 4)}\u2026${cfg.authToken.slice(-4)}` : "(none)",
      cloudUrl: cfg.wsUrl,
      localUrl: cfg.localWs
    };
  }
  window.TarteelCloudClient = TarteelCloudClient;
  window.TarteelEngine = {
    createTarteelClientAsync,
    resolveEngine,
    probeEngines,
    buildClient,
    TARTEEL_DEFAULT_ENDPOINT,
    TARTEEL_DEFAULT_TOKEN,
    TARTEEL_DEFAULT_USER_ID,
    TARTEEL_LOCAL_ENDPOINT: DEFAULTS.localWs,
    readConfig
  };
})();
