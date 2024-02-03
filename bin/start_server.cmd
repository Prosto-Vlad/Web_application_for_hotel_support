@echo on
echo Starting servers...
set PHP_FCGI_MAX_REQUESTS=0
cd D:\curs_server\bin\nginx-1.24.0\
D:\curs_server\bin\RunHiddenConsole.exe D:\curs_server\bin\nginx-1.24.0\nginx.exe
D:\curs_server\bin\RunHiddenConsole.exe D:\curs_server\bin\php\php-cgi.exe -b 127.0.0.1:9000 -c D:\curs_server\bin\php\php.ini