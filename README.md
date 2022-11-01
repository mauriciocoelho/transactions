## Sobre o App
Esse projeto é uma aplicação para armazenar transações financeiras de entrada e saída, que deve permitir o cadastro e a listagem dessas transações.

Stack's

Laravel com React de frontend e Mysql como banco de dados.


## Instalação e configuração
Para realizar a instalação deste repositório, faça os seguintes passos em seu terminal:

Clone o repositório em uma pasta  
```
git clone https://github.com/mauriciocoelho/transactions.git
```

Acesse o diretório do projeto
```
cd transactions
```

Instale as dependência utilizando o Composer dentro do pasta do projeto  
```
composer install
```

Faça uma cópia do arquivo de configuração  
```
linux
cp -R .env.example .env
windows
copy .env.example .env
```

Rodar o docker
```
docker-compose down
docker-compose up -d --build
```

Instalar o laravel
```
composer install
```

Limpar cache
```
php artisan cache:clear
php artisan config:clear
```

db
```
php artisan migrate:fresh --seed
```

Gere uma chave para a sua aplicação  
```
php artisan key:generate
```

## Iniciando a aplicação
Você pode iniciar a aplicação através do comando:  
```
php artisan serve
```

## Testando Api
Você utilizar o Postman ou Insomnia

### Listar Transações
```
GET /api/transactions
```
### Adicionar Transação
Para adicionar uma transação, faça uma chamada **POST** para o endereço abaixo  
```
POST /api/transactions
```
Os seguintes campos são necessários para adicionar um transação
```
- title (Obrigatório)
- value (Obrigatório, númerico)
- type (Obrigatório, pode ser income ou outcome)
```
### Testes Unitário
```
- php artisan test
```
