# phpGraphy-jasonsky

  1. 定制中文资源文件
          
  2. 修改视频播放插件
  
          <video id="shakeVideo" src="<% $picture[url] %>" type="video/mp4" autoplay loop muted playsinline preload controls width="540" height="300px">你的浏览器无法加载视频!</video>
  3. 修改ffmpeg生成视频缩略图
  
          ffmpeg -i input -ss 1 -vframes 100x100 -y -f mjpeg -vframes 1 output 2>&1
          
  4. Session开启
         
         index.php中 session_save_path() --设置路径， 否则默认为/var/lib/php/session
         注意：需要赋权  cd /var/lib   chmod -R 777 php

         修改/etc/php.ini
              session.save_path
         service php-fpm restart
         
         session --会话级，关闭浏览器失效
         cookie -- 客户端级，没有到过期时间还会保持（functions_global.inc.php： $expiration_date = time()+(60*24);）


# 部署安装
 1. 环境 nginx + php-fpm
     1> nginx配置
   
       
        server{
         listen 80;
         server_name photo.jasonsky.com.cn;
         client_max_body_size 50M;
         location / {
            root   /home/php/www/phpgraphy;
            index  index.php index.html index.htm;
            if ( !-e $request_filename){
                rewrite ^(.*)$ /index.php?s=/$1 last;
                break;
            }
            #proxy_pass http://localhost:9010/;
         }
         
         location /vedio {
              alias /home/php/www/phpgraphy/pictures/vedio; #你存放视频文件的目录
              autoindex on;
         }

         location ~ \.php$ {
               root         /home/php/www;
               fastcgi_pass   127.0.0.1:9010;
               fastcgi_index  index.php;
               fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
               include        fastcgi_params;
         }
        }

     2> php-fpm配置
     
         yum install php-fpm 
         vi /etc/php-fpm.d/www.conf 
         上传设置
         upload_max_filesize = 200M
         post_max_size = 200M
         端口设置 

  2. 软件
    ImageMagick（convert） + ffmpeg

    ffmpeg安装：
    //pel-release
    yum install -y epel-release
    yum update -y
    rpm --import /etc/pki/rpm-gpg/RPM-GPG-KEY-EPEL-7
    yum repolist

    //nux-dextop
    rpm --import http://li.nux.ro/download/nux/RPM-GPG-KEY-nux.ro
    rpm -Uvh http://li.nux.ro/download/nux/dextop/el7/x86_64/nux-dextop-release-0-1.el7.nux.noarch.rpm
    yum repolist
    yum install ffmpeg ffmpeg-devel -y


    问题：
    https://pkgs.org/download/ centos 依赖包
    Requires: libass.so.5()(64bit)

    wget ftp://195.220.108.108/linux/mageia/distrib/5/x86_64/media/core/updates/lib64ass5-0.13.4-1.mga5.x86_64.rpm

    rpm -ivh lib64ass5-0.13.4-1.mga5.x86_64.rpm

    libopenal.so.1()(64bit)
    wget http://download-ib01.fedoraproject.org/pub/epel/7/x86_64/Packages/o/openal-soft-1.16.0-3.el7.x86_64.rpm

    libschroedinger-1.0.so.0()(64bit)  -- liborc
    wget http://repo.okay.com.mx/centos/7/x86_64/release//schroedinger-1.0.11-5.el7.centos.x86_64.rpm
    wget http://pkgrepo.linuxtech.net/el6/release/x86_64/liborc-0.4.14-1.el6.x86_64.rpm

  3. 运行http://x.x.x.x:port/install.php进行安装即可


#  截图
    
   ![image](https://github.com/jasonSky/phpGraphy-jasonsky/blob/master/index.png)
