# laravel_realtime_chat
Implementation of websockets using laravel and laravel-cho-server

# HOW TO INSTALL

Clone this Repository

Rename .env.example file to .env

run : <pre>composer install</pre>

run : <pre>npm install</pre>

!! Install Redis into your machine if not isntalled !!

create a database 

migrate

run : <pre>npm install -g laravel-echo </pre>

run : <pre>laravel-echo-server init</pre>

Now it is ready to run

Just create 3 terminal windows and run the commands below to start this app :

<pre> php artisan serve </pre>

<pre> php artisan queue:listen </pre>

<pre> laravel-echo-server start</pre>

open http://localhost:8000/ and register

# Features

<ul>
    <li>Real Time Commet System</li>
    <li>Real Time Chat</li>
    <li>Like/Unlike</li>
</ul>
