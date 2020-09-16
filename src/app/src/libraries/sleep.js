const sleep = {
  async time(timeout) {
    return new Promise(resolve => setTimeout(resolve, timeout));
  }
};
export default sleep;