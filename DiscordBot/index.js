const discord = require('discord.js');
const bot = new discord.Client();
const mysql = require('mysql');

const conn = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'autism',
});

conn.connect((err) => {
  if (err) throw err;
  else console.log('Connected to Database.');
});

bot.on('message', (message) => {
  if (message.content == 'add') {
    const collector = new discord.MessageCollector(
      message.channel,
      (m) => m.author.id === message.author.id,
      { time: 10000 }
    );

    console.log(collector);

    collector.on('collect', async (message) => {
      await conn.query(
        'INSERT INTO tokenz (user_token) VALUES (?);',
        [message.content],
        (err, res) => {
          if (err) throw err;
          message.reply('Token was successfully added!');
        }
      );
    });
  } else if (message.content == 'blacklist') {
    const collector = new discord.MessageCollector(
      message.channel,
      (m) => m.author.id === message.author.id,
      { time: 10000 }
    );

    console.log(collector);

    collector.on('collect', async (message) => {
      await conn.query(
        `DELETE FROM dang WHERE user_username = '?';`,
        [message.content],
        (err, res) => {
          if (err) throw err;
          message.reply('Successfully Blacklisted!');
        }
      );
    });
  }
});

bot.login('token');
