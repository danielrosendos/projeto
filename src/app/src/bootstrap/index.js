import { axios } from '@/config';
import store from '@/store';
import { myStorage } from '@/store/storage';
const auth = myStorage.fetch('auth');
if (auth) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${auth.data.access_token}`;
    store.dispatch('userSignIn', auth);
}
