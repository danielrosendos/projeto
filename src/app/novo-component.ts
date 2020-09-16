start();

function start() {
  const prompt = require('prompt');
  prompt.start();
  prompt.get(['component'], (err, result) => {
    if (err) print(err);
    const base_path = `./src/components/${result.component}/`;
    const files = ['index.vue', 'components.js', 'services.js'];
    build(base_path, files[0], setIndex(result.component));
    build(base_path, files[1], setCompente(result.component));
    build(base_path, files[2], setServico(result.component));
    criaPastaComponent(base_path);
    return;
  });
}

function setCompente(component) {
  const novoNome = formataString(component);
  let body = "";
  body += `import vue from 'vue';\n`;
  body += `import app${novoNome}Index from './index';\n`;
  body += `vue.component('app-${component}-index', app${novoNome}Index);\n`;
  return body;

}

function setServico(component) {
  const novoNome = formataString(component);
  let body = "";
  body += `import { config, axios } from '@/config'; \n`;
  body += `\n`;
  body += `const service${novoNome} = {\n`;
  body += `\tasync exemplo() {\n`;
  body += `\t\t` + 'return axios.get(`${config.api.url}exemplo`);' + `\n`;
  body += `\t}\n`;
  body += `}\n`;
  body += `\n`;
  body += `export default service${novoNome};`;
  return body;
}

function setIndex(component) {
  let body = "";
  body += `<template>\n`;
  body += `\t<div> Component ${component} funcionou ! </div>  \n`;
  body += `</template>\n`;
  body += `<script>\n`;
  body += `\texport default {\n`;
  body += `\t\tdata() {\n`;
  body += `\t\t\treturn {}\n`;
  body += `\t\t}\n`;
  body += `\t}\n`;
  body += `</script>`;
  return body;
}

function build(path, arquivo, conteudo) {
  const arquivo_montado = `${path}${arquivo}`;
  const fs = require('fs');
  if (fs.existsSync(path)) {
    if (fs.existsSync(arquivo_montado)) {
      print(`Atenção !!! ${arquivo_montado} já existe!`);
    } else {
      escreverArquivo(arquivo_montado, conteudo);
    }
  } else {
    fs.mkdir(path, err => { if (err) print(err); });
    escreverArquivo(arquivo_montado, conteudo);
  }
}

function escreverArquivo(arquivo_montado, conteudo) {
  const fs = require('fs');
  fs.writeFile(arquivo_montado, conteudo, err => {
    if (err) return print(err);
    print(arquivo_montado);
  });
}

function criaPastaComponent(path) {
  const fs = require('fs');
  if (!fs.existsSync(`${path}components`)) {
    fs.mkdir(`${path}components`, err => { if (err) print(err); });
  }
}

function print(val) {
  console.log(val);
}

function formataString(string, separator = ' ') {
  return string
    .split(separator)
    .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
    .join(separator);
}
