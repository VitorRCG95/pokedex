## Introdução

Projeto criado para consultar e receber informações dos pokemons. Foi criado rotas para autenticação, atualizar a lista de pokemons da base de dados e consultar um pokemon especifico. Tudo foi feito pela rota api do Laravel e os retornos são em json.

## Iniciar configuração do projeto

para instalar e criar os containers e dependencias do projeto
docker-compose up -d --build

para executar os migrations do projeto laravel
docker exec -it laravel_app php artisan migrate

para gerar a key do laravel
docker exec -it laravel_app php artisan key:generate

## Rotas

Rota para gerar o Token, deve-se passar como Basic Auth o username e password. Sera retornado em json o token para utilizar nas próximas rotas.

http://localhost:8000/api/auth

Rota para carregar a lista dos pokemons. O token deve ser passado na propria url.

http://localhost:8000/api/getPokemons?token={token gerado}

Por padrão a consulta na api dos pokemons começa a lista por 0 e tras um limit de 20. Caso deseje mudar esta configuração, é só passar os parametros offset e limit na url. Sendo offset a ordenação.

http://localhost:8000/api/getPokemons?token={token gerado}&offset={valor}&limit={valor}

Rota para pesquisar o pokemon. Passa-se o token novamente na url e o id do pokemon desejado para receber as informações do mesmo.

http://localhost:8000/api/pokemon?token={token gerado}&id={id pokemon}