import axios from 'axios';


let config = {};
if (!prodution()) {
  config = {
    api: serialize('127.0.0.1/'),
    pusher: {
      key: '5e69969fec2396356747'
    },
  };
} else {
  config = {
    api: serialize('api.minhaapi.com.br', true),
    pusher: {
      key: '5e69969fec2396356747'
    },
  };
}

const storeKeys = {
  session: "@SESSION",
  auth: "@AUTH",
};

function serialize(url, ssl = false) {
  return {
    url: (ssl) ? `https://${url}` : `http://${url}`,
    key: '-',
    secret: '-',
    token: btoa(`-:`)
  };
}

function prodution() {
  if (process.env.VUE_APP_ENV == 'production') return true;
  return false;
}

export { axios, config, storeKeys };
