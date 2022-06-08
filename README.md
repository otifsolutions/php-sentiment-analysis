## Php Sentiment Analysis

Install via Composer

### Using Composer (Recommended)

You can run the following command in the root directory of your project:
```
composer require otifsolutions/php-sentiment-analysis
```
###Usage

+ __Php Sentiment Analysis allows user to analyze from a text statement__
+ __Analyze if the statement is positive or negative. e.g. comment on any post.__

   ```php
   Sentiment::make()->analyze($value);
   ```
  - Where $value is the statement to be analyzed.
    
+  Three possible types of sentiments are labels, emoji, negators.
   - Labels are letters or words passed in statement e.g. `corruption`, `boycott`.
   - Emoji contains emojis e.g. `😍`, `💖`.
   - Negators are words that negates something e.g. `doesnt`, `not`.
   
+  `getTokens` and `getDataSet` are private methods which have `token` and all three `sentiments`.

+  Token can be received from `getTokens` methode. 
+  All other data can be received from `getDataSet` methode. 
   
   Following are returned after analyses in an array.

      | Option       |Description                                           |
      |--------------|---------------------------------------------------|
      | `score`        |Score after analyze overall statement.    |
      | `comparative`  |Result score is divided by total number of tokens.   |
      | `calculation`   |This is value with value stored in dataset, if .              |
      | `tokens`        |Token is the statement which is passed to analyze if positive or negative.     |
      | `positive`      |Returns positive value from the statement otherwise nothing is returned.         | 
      | `negative`      |Returns negative value from the statement otherwise nothing is returned.         | 
   


