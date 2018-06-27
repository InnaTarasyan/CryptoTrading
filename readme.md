<b>My Coin Trading Project</b> connects to the following Crypto-Currency Market
Capitalization sites via api (implemented in the
background, using <i>laravel Task Scheduling</i>):
   <ul>
     <li>coinbin.org</li>
     <li>worldcoinindex.com </li>
     <li>coindar.org</li>
     <li>solume.io</li>
     <li>coinmarketcap.org</li>
   </ul>
   
   <b>General Information </b>
   <ul>
         <li>
            Information is displayed in <i>Laravel Datatables</i>, which includes table
             views (datagrids) with <i>pagination</i>, <i>searching</i> and 
             <i>sorting</i> capabilities. 
         </li>
         <li>TradingView Charts</li>
         <li>
             Site includes basic <i>login/logout/register functionality</i>. <br/>
         </li>
         <li> 
            <i>Metronic</i> theme is integrated.
         </li>
         <li>
             <i>Twitter</i> integration implemented. User can configure <i>Twitter account</i> </a>
             and the corresponding tweets will be retrieved.
         </li>
         <li>
            <i>Coin Events</i> are shown in the calendar.
         </li>
         <li> 
            <i>select2.js JQuery plugin</i> is used to search for a coin.
         </li> 
         <li>
            Project has a <i>chat</i> implemented using <i>node.js framework</i>
         </li>
    </ul>
 <br/>
 <br/>
 <b>Prerequisits</b>
 <ul>
   <li>Ensure you have PHP version 7.1.* </li>
   <li>Make sure that you have already installed (Node.JS).</li>
 </ul>
 <b>Running the site</b><br/>
 After you have cloned or downloaded the project, navigate to the corresponding directory
  <ul>
     <li>
     Install all the dependencies as specified in the <i>composer.json</i> file: <br/>
     composer install <br/>
     composer require thujohn/twitter <br/>
     php artisan vendor:publish <br/>
     </li>
     <li>
       Now open up /config/app.php and add the service provider to your providers array: <br/>
       'providers' => [ <br/>
       	Thujohn\Twitter\TwitterServiceProvider::class,
       ]
       <br/><br/>
       'aliases' => [ <br/>
       	'Twitter' => Thujohn\Twitter\Facades\Twitter::class,
       ]
     </li>
     <li>Copy the <i>.env.example</i> file to the <i>.env</i> file, and set the corresponding keys: <br/>
       <ul>
         <li>COIN_MARKET_CAP</li>
         <li>COINDAR</li>
         <li>SOLUME</li>
         <li>SOLUME_KEY (Register to Solume.io and get the key)</li>
         <li>COINBIN</li>
         <li> WORLD_COIN_INDEX</li>
         <li> WORLD_COIN_INDEX_KEY (Register to worldcoinindex.com and get the key) </li>
         <li> TWITTER_CONSUMER_KEY (Get Twitter Developer Consumer Key)</li>
         <li>TWITTER_CONSUMER_SECRET (Get Twitter Developer Consumer Secret)</li>
         <li> TWITTER_ACCESS_TOKEN (Get Twitter Developer Access Token)</li>
         <li>TWITTER_ACCESS_TOKEN_SECRET (Get Twitter Developer Access Token Secret)</li>
       </ul>
     </li>
    <li>Execute the <i>migrations</i> and run the <i>seeders</i> <br/> php artisan migrate
         <br/>composer dump-autoload
         <br/>php artisan db:seed
     ]
     </li>
     <li>For the <i>Linux</i> system cron, add the following Cron entry to your server: <br/> * * * * * php /path-to-the-project/artisan schedule:run >> /dev/null 2>&1 <br/> <i>Windows</i> has GUI equivalent called <i>Task Scheduler</i>, that can be made to perform similar function. <br/> You can <i>run schedules by hand</i>, by using this command in Command Prompt: <br/> php artisan schedule:run <br/> (however in this case, you've to run the command on your own for multiple times.)</li>
     <li>In your root directory, run this command in your terminal/command prompt. This will
      install all the corresponding node packages listed in 
      package.json file
     <br/> npm install
     </li>
     <li>In your root directory run the server using terminal / command prompt with this syntax :  
     <br/>node node/server.js
     </li>
  </ul>
  <b>Used Technologies</b>
  <ul>
    <li>Laravel task scheduling</li>
    <li>Creating own artisan commands</li>
    <li>Laravel Guzzle HTTP library</li>
    <li>Laravel Datatables</li>
    <li>Twitter API Integration</li>
    <li>select2.js JQuery Technology</li>
    <li>Markdown Parser</li>
    <li>Websocket API</li>
    <li>node-mysql node package</li>
    <li>http node package</li>
    <li>mysql node package</li>
  </ul>
  
 <b>ScrenShots</b>

 
 ![ScreenShot](https://i.imgur.com/ihZbK7W.png)
 ![ScreenShot](https://i.imgur.com/KTszq6n.png)
 ![ScreenShot](https://i.imgur.com/jloXifc.png)  
 ![ScreenShot](https://i.imgur.com/xKDY8Dq.png)
 ![ScreenShot](https://i.imgur.com/8HBKjp8.png)   
 ![ScreenShot](https://i.imgur.com/yQVg091.png)
 ![ScreenShot](https://i.imgur.com/oz4d8bA.png)
 ![ScreenShot](https://i.imgur.com/VpQ7u9y.png)
 ![ScreenShot](https://i.imgur.com/TLVsns3.png)
 ![ScreenShot](https://i.imgur.com/OenBeHT.png)
  