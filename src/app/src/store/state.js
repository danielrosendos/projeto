const state = {

  auth: {
    data: {
      access_token: "",
      expires_in: "",
      token_type: ""
    },
    logged: false
  },

  loarder: {
    color: "primary",
    visible: false,
  },

  snackbar: {
    color: "primary",
    visible: false,
    content: "",
  }

};

export default state;
