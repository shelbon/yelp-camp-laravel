# YelpCamp by Colt Steele

Codewell Yelcamp challenge's build with laravel and AWS Services

### Fonts Used

https://fonts.google.com/specimen/Archivo   

AWS SERVICE USED :

- AWS COGNITO 
- AWS SES 
- AWS S3  
- AWS DYNAMODB
- AWS Elastic beanstalk



## Run locally

### Prerequisites

- php,composer,python

- docker or docker desktop
- cognito  user pool and dynamodb 

- aws cli

### initial setup
install php dependencies
```bash
  # install dependencies
  composer install
```
create the APP_KEY in the .env file then
```bash
   # generate the app key value
   artisan key:generate
````
### AWS env variables
need to fill the .env file with values from your aws account and the respective service key
```bash
AWS_ACCESS_KEY_ID=
AWS_BUCKET=
AWS_COGNITO_CLIENT_ID=
AWS_COGNITO_CLIENT_NAME=
AWS_COGNITO_CLIENT_SECRET=
AWS_COGNITO_REGION=
AWS_COGNITO_USER_POOL_ID=
AWS_COGNITO_VERSION="latest"
AWS_DEFAULT_REGION=
AWS_REGION=
#path for other assets
AWS_S3_ASSETS_KEY="assets/"
AWS_S3_ENDPOINT=
# path to s3 key for campground image
AWS_S3_KEY="campground/"
AWS_SECRET_ACCESS_KEY=
DB_CONNECTION="dynamodb"
DYNAMODB_CONNECTION="aws"
DYNAMODB_ENDPOINT="dynamodb.<aws-region-here>.amazonaws.com"
DYNAMODB_KEY= 
DYNAMODB_REGION="eu-west-1"
DYNAMODB_SECRET=
FILESYSTEM_DISK="s3"
FILESYSTEM_DISK_PUBLIC="s3"
```
## Launch app

```bash
php artisan serve
```

 and launch the bundler(vite) in another 
 terminal

```bash
pnpm dev
# npm run dev
# yarn dev
```
### Launch  aws services locally using  localstack
some service need localstack Pro subscriptions(cognito)

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

## Deployment via  elastic beanstalk command line interface

## Prerequisites
   - An AWS account

## Setup environment
create environment,if no application was created before 
it will ask you to select the aws region and  some imformation
to create the environment
```shell
 eb create environment-name
```

send environment from .env file to elastic beanstalk env after 
that rebuild the environment on main page on aws elastic beanstalk
section
```shell 
  eb setenv `cat .env | sed '/^#/ d' | sed '/^$/ d'`
```

when some change are done, commit the file then
```shell
 eb deploy
```
