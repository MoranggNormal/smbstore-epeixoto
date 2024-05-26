# SMB Store

https://smb.epeixoto.dev

[Vídeos demonstrativos](https://www.youtube.com/watch?v=sgwNaEUbUAU&list=PLX00v7ikWSwd0bIZFLjBQ29ch6YhsebMn)

---

## Atenção:

Utilize a branch **DEV** para aproveitar 100% do projeto, precisei fazer alterações hardcode na branch **master** para fazer deploy (e não vou conseguir dar devida atenção a isso agora, preciso finalizar outro projeto em tempo recorde!).

---

### Qual a finalidade?

Este repositório visa mostrar minhas habilidades de programação afim de garantir uma vaga como programador na SMB Store.

Em resumo, a tarefa do candidato é desenvolver um CRUD para gerenciamento de usuários.

### O que foi feito?

Foi preparado um ambiente em docker contendo as seguintes tecnologias:

- CodeIgniter 3:

```diff
+ Criação das rotas **/api/store\*\*** e **/api/auth\*\***;
+ Cadastro/Login/Logout utilizando o session do codeigniter;
+ Validação de formulários;
+ Boas práticas de código, como documentação de parâmetros da API e uso de constantes para praticidade;
```

- VueJS 2:

```diff
+ Materialize CSS para estilização;
+ Pinia para gerenciamento de estados;
+ Axios para manuseio de API;
+ Vue-the-mask para aplicar máscara em formulários;
+ Boas práticas de código, como documentacao de parâmetros da API e uso de constantes para praticidade;
```

- MySQL:

```diff
+ Criação de tabelas e colunas para bom funcionamento da plataforma;
```
![image](https://github.com/MoranggNormal/smbstore-epeixoto/assets/72574532/bfd15a00-9098-425d-9769-6a70a36c1af0)

Exemplo de .env:

```
SERVER_HOST="http://localhost"
CLIENT_HOST="http://localhost:3000"

DB_HOST="database"
DB_PORT=3306
DB_NAME="smbepeixoto"
DB_ROOT_USER="root"
DB_ROOT_PASSWORD="root"
DB_USER="smb"
DB_PASSWORD="smb"
```

Não criei uma documentação completa para a API por falta de tempo, como explicado nos [vídeos de resultados.](https://www.youtube.com/watch?v=sgwNaEUbUAU&list=PLX00v7ikWSwd0bIZFLjBQ29ch6YhsebMn)

Não tenho permissão para compartilhar os dados sobre o desafio, mas fiz algumas coisas a mais já que planejo utilizar esse sistema no futuro.

---

Duvidas? [contato@epeixoto.dev](mailto:contato@epeixoto.dev)
