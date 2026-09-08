const DB_NAME = 'SmartSchoolDB';
const DB_VERSION = 1;
const STORE_NAME = 'offline_queue';

let db;
const request = indexedDB.open(DB_NAME, DB_VERSION);

request.onupgradeneeded = function(event) {
    db = event.target.result;
    if (!db.objectStoreNames.contains(STORE_NAME)) {
        db.createObjectStore(STORE_NAME, { keyPath: 'id', autoIncrement: true });
    }
};

request.onsuccess = function(event) {
    db = event.target.result;
    if (navigator.onLine) {
        syncOfflineQueue();
    }
};

window.saveToOfflineQueue = async function(actionUrl, formData) {
    let formEntries = [];
    for (let [key, value] of formData.entries()) {
        formEntries.push({key: key, value: value});
    }

    const tx = db.transaction(STORE_NAME, 'readwrite');
    const store = tx.objectStore(STORE_NAME);
    store.add({
        url: actionUrl,
        entries: formEntries,
        timestamp: new Date().toISOString()
    });

    return new Promise((resolve, reject) => {
        tx.oncomplete = () => resolve();
        tx.onerror = () => reject(tx.error);
    });
};

window.syncOfflineQueue = function() {
    if (!db) return;
    const tx = db.transaction(STORE_NAME, 'readonly');
    const store = tx.objectStore(STORE_NAME);
    const mRequest = store.getAll();

    mRequest.onsuccess = function() {
        const items = mRequest.result;
        if (items.length > 0) {
            console.log("Syncing " + items.length + " offline items...");
        }
        for (let item of items) {
            let fd = new FormData();
            item.entries.forEach(entry => {
                fd.append(entry.key, entry.value);
            });

            $.ajax({
                url: item.url,
                type: "POST",
                data: fd,
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                success: function(data) {
                    if (data.status === "success" || data.status === "access_denied") {
                        const delTx = db.transaction(STORE_NAME, 'readwrite');
                        delTx.objectStore(STORE_NAME).delete(item.id);
                    }
                }
            });
        }
    };
};

window.addEventListener('online', syncOfflineQueue);
