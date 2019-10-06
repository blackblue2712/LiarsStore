var PORT    = 8080;
var express = require('express');
var app     = express();
var http    = require('http');
var server  = http.Server(app);

app.use(express.static('client'));
server.listen(PORT, () =>{
    console.log("Node js running .............");
})

//SOCKET IO
const io = require('socket.io').listen(server);

//MYSQL
const connnection = require('mysql').createConnection({
    host    : "localhost",
    user    : "root",
    password: "",
    database: "larsgallery"
});


io.sockets.on('connection', (socket) =>{
    console.log("client connected...");
    //AUTH 
    socket.on('auth-cart-checkout', (data) =>{
        socket.broadcast.emit('auth-cart-checkout', data);
        connnection.query("UPDATE `notifications` SET `is_seen` = 0, `status` = `status` + ? WHERE content = ?", [data.countSelectedItem, 'sales made'], (err, result) =>{
            if(err) throw err;
            else console.log(result);
        });
    })
    socket.on('admin-cart-deleteBadge', () =>{
        connnection.query("UPDATE `notifications` SET `is_seen` = 1, status = 0 WHERE `content` = ?", ['sales made'], (err, result) =>{
            if(err) throw err;
            else console.log(result);
        });
        socket.emit('admin-cart-deleteBadge');
    })
})