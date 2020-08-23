const discord = require("discord.js");
const bot = new discord.Client();
var mysql = require("mysql");


var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "autism"
});

bot.on('message', (message) => {

  //  var variableToken;

    if (message.content == "add") {
        const collector = new discord.MessageCollector(message.channel, m => m.author.id === message.author.id, { time: 10000 });
        console.log(collector);
        collector.on('collect', message => {
            var bruh = message.content;

         //   message.reply("Connected!");
                var sql = "INSERT INTO tokenz (user_token) VALUES ('"+ bruh +"')";
                con.query(sql, function (err, result) {
                    if (err) throw err;
    
                    message.reply("Token was successfully added!");
                   
                }); 
          //  });
            
        });
    }
    else if (message.content == "blacklist"){
      
        const collector = new discord.MessageCollector(message.channel, m => m.author.id === message.author.id, { time: 10000 });
        console.log(collector);
        collector.on('collect', message => {
            var blacklistedPerson = message.content;

          //  con.connect(function(err) {
            //    if(err) throw err;
    
            //    message.reply("Connected!");

                var sqli = "DELETE FROM dang WHERE user_username = '" + blacklistedPerson +  "'";
                con.query(sqli, function(err, result) {
                    if(err) throw err;
    
                    message.reply("Successfully Blacklisted!");
                    
                });
           // });
        });
        
    }

});

bot.login("token");
