/**
 * Tahsin Academy - Student Live Telemetry & Focus Pulse Agent
 * Location: assets/js/tahsin-pulse.js
 * 
 * Tracks student presence, tab-focus status, hand-raising, screen locks,
 * and handles real-time formative check prompts.
 */
(function() {
    'use strict';

    window.TahsinPulse = {
        sessionId: 0,
        studentId: 0,
        isHandRaised: false,
        handNote: '',
        lastMeritId: 0,
        pollAnswered: false,
        heartbeatTimer: null,

        init: function(config) {
            this.sessionId = config.sessionId || 0;
            this.studentId = config.studentId || 0;
            this.baseUrl   = config.baseUrl || '/';

            if (!this.sessionId) {
                console.warn('[TahsinPulse] No active session ID provided.');
                return;
            }

            console.log('[TahsinPulse] Initialized for session:', this.sessionId);

            // Bind visibility events for immediate zero-latency reporting
            window.addEventListener('blur', () => this.sendBeacon('Window blurred / Tab switched'));
            window.addEventListener('focus', () => this.sendBeacon('Back in active tab'));
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    this.sendBeacon('Tab hidden');
                } else {
                    this.sendBeacon('Tab active');
                }
            });

            // Start heartbeat loop every 5 seconds
            this.sendBeacon('Joined Classroom');
            this.heartbeatTimer = setInterval(() => this.sendBeacon(), 5000);
        },

        sendBeacon: function(taskNote) {
            if (!this.sessionId) return;

            const isFocused = document.hasFocus() && !document.hidden;
            const payload = {
                session_id: this.sessionId,
                student_id: this.studentId,
                is_focused: isFocused ? 1 : 0,
                current_task: taskNote || (isFocused ? 'Viewing Lesson' : 'Tab Switched / Unfocused'),
                hand_raised: this.isHandRaised ? 1 : 0,
                hand_note: this.handNote
            };

            fetch(this.baseUrl + 'live_session/student_ping', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    this.handleServerDirectives(data);
                }
            })
            .catch(err => console.debug('[TahsinPulse] Ping offline:', err));
        },

        handleServerDirectives: function(data) {
            // 1. Handle "Eyes Up" screen freeze
            const lockModal = document.getElementById('tahsin-screen-lock-modal');
            if (lockModal) {
                if (data.screen_locked) {
                    lockModal.style.display = 'flex';
                } else {
                    lockModal.style.display = 'none';
                }
            }

            // 2. Handle merit badge award
            if (data.latest_merit && data.latest_merit.id !== this.lastMeritId) {
                this.lastMeritId = data.latest_merit.id;
                this.showMeritCelebration(data.latest_merit.merit_badge, data.latest_merit.points);
            }

            // 3. Handle active formative poll
            if (data.active_poll && data.active_poll.id) {
                this.renderActivePoll(data.active_poll);
            } else {
                const pollContainer = document.getElementById('tahsin-live-poll-card');
                if (pollContainer) pollContainer.style.display = 'none';
            }

            // 4. Handle hand-raise dismissal by facilitator
            if (data.hand_raised === 0 && this.isHandRaised) {
                this.isHandRaised = false;
                const btn = document.getElementById('btn-raise-hand');
                if (btn) {
                    btn.classList.remove('active');
                    btn.innerHTML = '<i class="fa fa-hand-paper"></i> Raise Hand for Help';
                }
            }
        },

        toggleHandRaise: function() {
            this.isHandRaised = !this.isHandRaised;
            const btn = document.getElementById('btn-raise-hand');
            if (btn) {
                if (this.isHandRaised) {
                    btn.classList.add('active');
                    btn.innerHTML = '<i class="fa fa-hand"></i> Hand Raised (Facilitator Notified)';
                } else {
                    btn.classList.remove('active');
                    btn.innerHTML = '<i class="fa fa-hand-paper"></i> Raise Hand for Help';
                }
            }
            this.sendBeacon(this.isHandRaised ? 'Hand raised for assistance' : 'Hand lowered');
        },

        showMeritCelebration: function(badgeName, points) {
            const toast = document.getElementById('tahsin-merit-toast');
            if (!toast) return;

            document.getElementById('merit-toast-title').innerText = `+${points} Merit Points Awarded!`;
            document.getElementById('merit-toast-desc').innerText = `Commendation: ${badgeName}`;
            toast.classList.add('show');

            // Play gentle chime sound if Web Audio supported
            this.playAudioChime();

            setTimeout(() => {
                toast.classList.remove('show');
            }, 4500);
        },

        playAudioChime: function() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(587.33, ctx.currentTime); // D5
                osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.15); // A5
                gain.gain.setValueAtTime(0.3, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.4);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.4);
            } catch (e) {
                // Audio autoplay might be blocked
            }
        },

        renderActivePoll: function(poll) {
            const card = document.getElementById('tahsin-live-poll-card');
            if (!card) return;

            if (this.currentPollId !== poll.id) {
                this.currentPollId = poll.id;
                this.pollAnswered = false;
            }

            if (this.pollAnswered) return;

            card.style.display = 'block';
            document.getElementById('poll-prompt-text').innerText = poll.prompt_text;
            const optionsBox = document.getElementById('poll-options-container');
            optionsBox.innerHTML = '';

            const options = poll.options || ['A: Clear 👍', 'B: Need Help 🤔'];
            options.forEach(opt => {
                const btn = document.createElement('button');
                btn.className = 'btn-poll-option';
                btn.innerText = opt;
                btn.onclick = () => this.submitPollAnswer(poll.id, opt);
                optionsBox.appendChild(btn);
            });
        },

        submitPollAnswer: function(checkId, answer) {
            this.pollAnswered = true;
            const card = document.getElementById('tahsin-live-poll-card');
            if (card) {
                card.innerHTML = `<div style="text-align:center; padding:15px; color:#10b981; font-weight:700;">
                    <i class="fa fa-check-circle" style="font-size:24px;"></i><br>
                    Response submitted! Thank you.
                </div>`;
            }

            fetch(this.baseUrl + 'live_session/submit_poll', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    check_id: checkId,
                    session_id: this.sessionId,
                    student_id: this.studentId,
                    answer: answer
                })
            });
        }
    };
})();
