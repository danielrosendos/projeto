const helpers = {

  minDateEnem() {
    const date = new Date();
    const anoAtual = date.getFullYear();
    return (anoAtual - 10) + "/04/02";
  },
  
  isFullName(nome) {
    if (!this.isUndefined(nome)) {
      nome = nome.trim();
      const splited = nome.split(" ");
      return (splited.length > 1);
    } else {
      return false;
    }
  },

  enemGrade(val) {
    return (val <= 1000);
  },

  isUndefined(val) {
    return (val === undefined);
  },

  isEmpty(val) {
    if (!val) return true;
    if (val.length === 0) return true;
    if (this.isUndefined(val)) return true;
    return false;
  },

  isEmail(val) {
    const rgx = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
    return rgx.test(val);
  },

  isCPF(val) {
    if (val.length > 11) return false;
    let soma = 0;
    let resto = 0;
    val = val.replace(/\D+/g, '');
    if (val === "00000000000") return false;
    for (let i = 1; i <= 9; i++) soma = soma + parseInt(val.substring(i - 1, i)) * (11 - i);
    resto = (soma * 10) % 11;
    if ((resto === 10) || (resto === 11)) resto = 0;
    if (resto != parseInt(val.substring(9, 10))) return false;
    soma = 0;
    for (let i = 1; i <= 10; i++) soma = soma + parseInt(val.substring(i - 1, i)) * (12 - i);
    resto = (soma * 10) % 11;
    if ((resto === 10) || (resto === 11)) resto = 0;
    if (resto != parseInt(val.substring(10, 11))) return false;
    return true;
  }

};

export default helpers;