### comandos npm
```
npm install
npm run serve
npm run build
```
### Autenticacao

Configure a estrutura do state.auth com base no retorno 
da rota de autenticação de sua API REST

### Core
Para utilizar a logo, basta definir no seu template a tag 
< app-indentidade/ >

** recurso de load **
Se você quiser carregar o load por um tempo finito. 
```
await this.$load.load(tempoDeLoadEmMiliSegundos);
```
***OBS.:*** Caso não seja passado valor, o load dura 1000 ms.

Caso queria carregar o load e parar quando um outro processo terminar, use
```
this.$load.loadOpen();
await this.SeuProcessoAssincrono();
this.$load.loadDismiss();
```
** recurso de snackbar **

Você pode chamar o snakBar com o comando global
```
this.$load.snackbar("mensagem", "cor");
```
***OBS.:*** Campo mensagem obrigatório. Caso cor não seja passado por padrão será carregada a cor primary

Se não quiser perder tempo nos catchs, pode usar:
```
this.$load.snackbarError(err);
```
Este irá subir o snackbar com uma mensagem genérica, cor error e um console.log(err)


### Novo componente

Para otimizar o tempo e padronizar as coisas, você pode criar um novo componente com o seguinte comando no terminal:
```
node novo-component.ts
```

Ele irá perguntar o nome do componente que você deseja criar.
Depois de informado, ele irá gerar o seguinte sistema de pastas

@src/components/nome-do component
- index.vue
- services.js
- components.js
- components/ (pasta vazia)

Para que ele se torne público, você deve fazer a seguinte configuração

**Cadastre o componet  em @src/components/index.js
**

exemplo:

	require('./nome-do-componente/components');

Depois cadastre o serviço em @src/services/index.js

	import serviceNomeDoComponent from '@/components/nome-do-componente/services';
	vue.prototype.$serviceNomeDoComponent = serviceNomeDoComponent;
