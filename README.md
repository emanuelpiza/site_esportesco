# site_esportesco

Criar uma instância AWS em São Paulo. Configurar o ssh com a key pair.

Instalar o servidor FTP
http://stackoverflow.com/questions/7052875/setting-up-ftp-on-amazon-cloud-server

Instalar Apache e MySQL
http://www.chrishjorth.com/blog/free-aws-ec2-ubuntu-apache-php-mysql-setup/

Baixar o Sequel e preencher com os dados e chave-pem recém criados. Rodar então o script de inicialização da base.

Instalar o Git
https://help.github.com/articles/set-up-git/

git clone https://github.com/emanuelpiza/site_esportesco
Ajustar permissão dos arquivos
sudo chown -R www-data:www-data /var/www
sudo chmod -R g+rw /var/www


Mudar o / do apache pra dentro de site_esportesco
sudo vi /etc/apache2/sites-available/000-default.conf 
sudo service apache2 restart

Instalar o FFmpeg
https://trac.ffmpeg.org/wiki/CompilationGuide/Ubuntu
