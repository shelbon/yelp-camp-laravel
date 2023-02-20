# YelpCamp by Colt Steele

Codewell Yelcamp challenge's build with laravel and AWS Services

### Fonts Used

https://fonts.google.com/specimen/Archivo   

AWS SERVICE USED :

- AWS INCOGNITO ✔️
- AWS SES ✔️
- AWS S3  ✔️
- AWS DYNAMODB  ✔️
- AWS lambda
- AWS API GATEAWAY



## Run locally

### Prerequisites

- php,composer,python

- docker or docker desktop

- aws cli

Launch app 

```bash
php artisan serve
```

launch the bundler(vite)

```bash
pnpm dev
# npm run dev
# yarn dev
```

and launch localstack for using aws service  locally

start container

```bash
docker compose up
```

stop container

```bash
docker compose stop
```

delete container

```bash
docker compsoe down
```

## Deployement via  elastic beanstalk command line interface

## Prerequisites
   - A AWS account

## setup environment
create environment,if no application was created before 
it will ask you to select the aws region and  some imformation
to create the environment
```shell
 eb create environment-name
```

send environment from .env file to elastic beanstalk env after 
that rebuild the environment on environment page on aws website
```shell 
  eb setenv `cat .env | sed '/^#/ d' | sed '/^$/ d'`
```

when some change are done, commit the file then
```shell
 eb deploy
```
