# Csiha_taskmanager
Taskmanager app with laravel-vue-inertia

Feltételek a telepítéshez  
	-Docker Desktop  
	-Composer

1. Projekt klónozása:  
	-git clone https://github.com/LazarMartin99/Csiha_taskmanager.git  

2. Függőségek telepítése és az alkalmazás futtatása  
	-cd Csiha_taskmanager  
	-composer install  
	-php artisan sail:install  
	-./vendor/bin/sail up  
	-./vendor/bin/sail npm install  
	-./vendor/bin/sail npm run dev  
	-./vendor/bin/sail php artisan migrate  

3. Teszt  
	-Az alkalmazás a http://localhost/ URL-en érhető el a böngészőben.  
