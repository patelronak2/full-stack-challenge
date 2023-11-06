
# Wise Publishing Full Stack Challenge

Simple Job Board to demonstrate capabilities as fullstack developer



## Demo

[http://wise-jobs.ca-central-1.elasticbeanstalk.com/](http://wise-jobs.ca-central-1.elasticbeanstalk.com/)


## Installation

Clone the repo locally

```bash
  git clone <url>
  cd full-stack-challenge
  npm install
  composer install
```

copy .env.example into .env and update the values

## Run Locally

Make sure app key is generated

```bash
  php artisan key:generate --ansi
```

Migrate and populate DB

```bash
   php artisan migrate
   php artisan db:seed
```

Start the server

```bash
   php artisan serve
   npm run dev
```
## Tech Stack

**Client:** Vue, TypeScript, TailwindCSS, Inertia

**Server:** Laravel


## Authors

- [@patelronak2](https://www.github.com/patelronak2)

