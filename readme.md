# Proof of concept

### Tracking device in real time using web sockets

1. Using **PHP** + **[Redis](https://redis.io/)** to fake **device** reporting
2. Using **NodeJS**: **[Express](https://expressjs.com/)** + **[Socket.IO](https://socket.io/)** to fake **Communication Server**
3. Using **JS** + **[Socket.IO](https://socket.io/)** to **track** device in real time

### Getting started:

**Install PHP dependencies**

`composer install`

**Install NodeJS dependencies**

`npm install`

Set Google Maps API key in [index.html](https://github.com/mtvbrianking/web-sockets-geo-app/blob/master/public/index.html)

**Start comm server**

`node index.js`

**Fake device location reports**

`php device.php`

**Track device in browser**

`http://localhost:4000`
