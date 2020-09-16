
const api = {

  setQueryString(payload = null) {
    if (payload === null) {
      return '';
    }
    let body = '?';
    Object.keys(payload).forEach((key) => {
      body += `${key}=${encodeURIComponent(payload[key])}&`;
    });
    return body.substring(0, (body.length - 1));
  }

};

export default api;