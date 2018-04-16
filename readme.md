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
Information is displayed in <i>Laravel Datatables</i>, which includes table
 views (datagrids) with <i>pagination</i>, <i>searching</i> and 
 <i>sorting</i> capabilities. <br/>
 Also, site includes basic <i>login/logout/register functionality</i>. <br/>
 <i>Metronic</i> theme is integrated.
 <br/>
 <br/>
 <b>Prerequisits</b>
 <ul>
   <li>Ensure you have PHP version 7.1.* </li>
 </ul>
 <b>Running the site</b><br/>
 After you have cloned or downloaded the project, navigate to the corresponding directory
  <ul>
     <li>
     Install all the dependencies as specified in the composer.lock file (in your terminal). <br/>
     cd cryptoTrading <br/>
     composer install 
     </li>
     <li>Copy the .env.example file to the .env file, and set the corresponding keys</li>
     <li> Run the site <br/> php artisan serve --host=your_host --port=your_port <br/> Alternatively, create a virtual host. <br/>
     </li>
     <li>Execute the migrations <br/> php artisan migrate</li>
     <li>For the Linux system cron, add the following Cron entry to your server: <br/> * * * * * php /path-to-the-project/artisan schedule:run >> /dev/null 2>&1 <br/> Windows has GUI equivalent called Task Scheduler, that can be made to perform similar function. <br/> You can run schedules by hand, by using this command in Command Prompt: <br/> php artisan schedule:run <br/> (Remember to navigate to project directory first.)</li>
  </ul>