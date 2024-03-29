
![Badge em Desenvolvimento](http://img.shields.io/static/v1?label=STATUS&message=EM%20DESENVOLVIMENTO&color=GREEN&style=for-the-badge)

# Índice 

* [TutorialPipeLine](#tutorialpipeLine)
* [Instalação Amazon Linux 2](#amazonlinux)
* [Equipe Brasmid](#brasmid)
* [Equipe IMW](#imw)

<h4 id="tutorialpipeLine">Tutorial PipeLine</h4>

<a href="https://medium.com/@peacevan/criando-um-simples-pipeline-ci-cd-com-githubaction-laravel-aws-ec2-31d1cbe90184">Link do tutorial</p>

<ol>
    <li>crie uma pasta em seu projeto .github/workflows</li>
    <li>crie o arquivo deploy-aws.yml</li>
    <li>adicione o seguinte código</li>
</ol>

```
name: CI Pipeline

on:
  pull_request:
    branches:
      - master

jobs:
  check-application:
    runs-on: ubuntu-latest

    steps:
    - name: Checkout code
      uses: actions/checkout@v2

    - name: Setup SSH
      uses: webfactory/ssh-agent@v0.5.0
      with:
        ssh-private-key: ${{ secrets.SSH_PRIVATE_KEY }}

    - name: Deploy to EC2
      run: |
        ssh -o StrictHostKeyChecking=no ec2-user@${{ secrets.EC2_PUBLIC_IP }} ' cd /var/www/html && pwd && git pull origin master' 
        ssh -o StrictHostKeyChecking=no ec2-user@${{ secrets.EC2_PUBLIC_IP }} ' cd /var/www/html/imw &&  sudo composer install --no-interaction --prefer-dist --optimize-autoloader'
        ssh -o StrictHostKeyChecking=no ec2-user@${{ secrets.EC2_PUBLIC_IP }} ' cd /var/www/html/imw && php artisan migrate --force'
```

<h4 id="amazonlinux">Instalação Amazon Linux 2</h4>

<h5>1. Instalar o Nginx</h5>

```
sudo yum install nginx -y
sudo systemctl start nginx
sudo systemctl enable nginx
```

<h5>2. Instalar o PHP 8.2.x</h5>

```
sudo yum install -y php php-cli php-fpm php-mysqlnd php-zip php-devel php-gd php-mbstring php-curl php-xml php-pear php-bcmath php-json
sudo systemctl start php-fpm
sudo systemctl enable php-fpm
```

<h5>3. Configurar o Nginx para o Laravel</h5>

```    
server {
        listen 80;
        server_name homolog.imwpga.com.br; 
        root /var/www/html/imw/public; # Substitua pelo caminho correto

        index index.php index.html;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location ~ \.php$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_pass unix:/var/run/php-fpm/www.sock; # Verifique o caminho correto
            try_files $uri =404;
        }
    }
```

```
sudo nginx -t
sudo systemctl restart nginx
```

<h5>4. Instalar o Certbot para Certificado SSL</h5>

```
sudo yum install certbot python3-certbot-nginx -y
sudo certbot --nginx -d homolog.imwpga.com.br 
```

<h5>5. Configurar o Laravel</h5>

```
sudo chown -R nginx:nginx /var/www/laravel
sudo chmod -R 777 /var/www/laravel/storage
sudo chmod -R 755 /var/www/laravel/bootstrap/cache
```

<h5>6. Instalando o git </h5>

```
sudo yum install git -y
git --version
```

cd /var/www/hml/

```
git clone https://github.com/Lioh23/imw.git
```

<h5>7. Configurando o arquivo .env</h5>

```
mv /var/www/html/imw/.env.example /var/www/html/imw/.env
```

<h5>8. Instalando o Composer</h5>

```
sudo curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```
cd /var/www/hml/imw 
#dentro da pasta /var/www/hml/imw

```
composer install #dentro da pasta /var/www/hml/imw , digite Y em todas as etapas
sudo php artisan migrate #rodar as migrações
sudo sudo php artisan db:seed #rodas os seeds iniciais
```

<h5 id="brasmid">✒️ Equipe Brasmid</h5>
<ul>
    <li>Vinicius Almeida - <a href="https://github.com/valmeidavr">https://github.com/valmeidavr</a>
    </li>
    <li>Aurelio de Jesus - <a href="https://github.com/Lioh23"> https://github.com/Lioh23</a>
    </li>
    <li>Pedro Medeiros - <a href="#">Não informado</a></li>
</ul>


<h5 id="imw">✒️Equipe IMW</h5>
<ul> 
    <li>Marcos Batista</li>
    <li>Johnatton</li>
</ul>

