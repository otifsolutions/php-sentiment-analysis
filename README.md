## Php Sentiment Analysis

Install via Composer

### Using Composer (Recommended)

You can run the following command in the root directory of your project:

```
composer require otifsolutions/php-sentiment-analysis
```

### Usage

+ __Php Sentiment Analysis allows to analyze a text statement if it is positive or negative. e.g. comment on any post.__

   ```php
   Sentiment::make()->analyze($value);
   ```
    - Where $value is the statement to be analyzed.

+ Statement may contain labels, emojis and negators.
    - Labels are words statement contains e.g. `corruption`, `boycott`.
    - Emoji e.g. `😍`, `💖`.
    - Negators are words that negate something e.g. `doesnt`, `not`.

+ __We use following methods__
  
  + `getTokens` method
    - This method separate the words from the given statement and returns all words.
  
  + `getDataSet` method
    - This method has dataset.
    - Labels, emojis and negators are stored in the dataset, which have a positive or negative value.
    - For example  `"fun": 4, "funeral": -1,`

This example demonstrates the usage of `Php Sentiment Analysis`,

  ```php
    Sentiment::make()->analyze('She is famous, but she hates others.');
  ```

  ```
    {
     "score": -1,
     "comparative": -0.14285714285714285,
     
     "calculation": [
       {"she": 0},{"is": 0},{"famous": 2},{"but": 0},{"she": 0},{"hates": -3},{"others": 0}
       ],
    
     "tokens":  [
      "she","is","famous","but","she","hates","others"
        ],
   
     "positive": [
        "famous"
        ],
   
     "negative": [
        "hates"
        ]
    }
  ```

| Option          |  Description                                                                     |
|-----------------|----------------------------------------------------------------------------------|
| `score`         |Positive or negative value after analysis of given statement.                           |
| `tokens`        |Tokens are the separated words in a Statement.                         |
| `comparative`   |Value received when score is divided by count of token.                                  |
| `calculation`   |Words in an array with a positive or negative value, if the word exists in `dataset` the value will be positive or negative otherwise value will be zero.                           |
| `positive`      |Shows all positive words from the statement.         | 
| `negative`      |shows all negative words from the statement.         | 

