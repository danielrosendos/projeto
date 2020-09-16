import { storeKeys } from '@/config';

const persistedStorage = JSON.parse(localStorage.getItem(storeKeys.auth)) || {};

const myStorage = {
  persist(key, payload) {
    persistedStorage[key] = payload;
    localStorage.setItem(storeKeys.auth, JSON.stringify(persistedStorage));
  },
  remove(key) {
    persistedStorage[key] = undefined;
    localStorage.setItem(storeKeys.auth, JSON.stringify(persistedStorage));
  },
  fetch(key) {
    return persistedStorage[key];
  }
};

export { myStorage };
