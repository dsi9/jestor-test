# Teste Jestor - APP Crud de Tarefas

## Descrição
- App em Reactjs com tela de login e CRUD de tarefas. 
- API PHP. Desenvolvi a estrutura baseada em "MVC".
## Uso

### Dependências
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [GNU Make](https://www.gnu.org/software/make/)

Inicie o projeto rodando o comando abaixo:

```
make setup
```

_Este comando criará a rede do docker, containers, instala as dependencias do composer, faz o build do app e exibe os logs_. \
_Se tudo estiver ok, exibirá os logs._

A API ficará disponível em [http://localhost:8080/api](http://localhost:8080/api).

Acessando o App em [http://localhost:8080/app](http://localhost:8080/app), Utilize o email e senha abaixo para entrar.
```
Email: test@test.com
Senha: 123123
```

## Extras

#### Make help
```
make help
```
#### Documentação API

```
Host: localhost:8080
```

Login:
```
POST /api/login
Content-Type: application/json

{
    "email": "<string>",
    "password": "<string>"
}

Retun:
HTTP 200 Ok
{
    "data": {
        "basic": "<string>"
    }
}
```

Lista de Tarefas:
```
GET /api/todo-list
Authorization: <Basic - string>
Content-Type: application/json

Return:
HTTP 200 Ok
{
    "data": [
        {
            "id": <int>,
            "subject": "<string>",
            "description": "<string>",
            "date": "<string>"
        }
    ]
}
```

Tarefa:
```
GET /api/todo-list/{id}
Authorization: <Basic - string>
Content-Type: application/json

Return:
HTTP 200 Ok
{
    "data": {
        "id": <int>,
        "subject": "<string>",
        "description": "<string>",
        "date": "<string>"
    }
}
```

Inserir tarefa:
```
POST /api/todo-list
Authorization: <Basic - string>
Content-Type: application/json
{
    "id": <int>,
    "subject": "<string>",
    "description": "<string>",
    "date": "<string>"
}

Return:
HTTP 201 Created
{
    "data": {
        "id": <int>,
        "subject": "<string>",
        "description": "<string>",
        "date": "<string>"
    }
}
```

Atualizar tarefa:
```
PUT /api/todo-list/{id}
Authorization: <Basic - string>
Content-Type: application/json
{
    "id": <int>,
    "subject": "<string>",
    "description": "<string>",
    "date": "<string>"
}

Return:
HTTP 202 Accepted
{
    "data": {
        "id": <int>,
        "subject": "<string>",
        "description": "<string>",
        "date": "<string>"
    }
}
```

Remover tarefa:
```
DELETE /api/todo-list/{id}
Authorization: <Basic - string>
Content-Type: application/json

Return:
HTTP 204 No Content
```

Errors:
```
Return:
400 Bad Request | 401 Unauthorized | 404 Not Found | 405 Method Not Allowed | 409 Conflict | 500 Internal Server Error
{
    "error": <int>,
    "message": "<string>",
    "trace": "<string>"
}
```