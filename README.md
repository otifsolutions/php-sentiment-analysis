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
    - Labels are letters or words passed in statement e.g. `corruption`, `boycott`.
    - Emoji contains emojis e.g. `😍`, `💖`.
    - Negators are words that negates something e.g. `doesnt`, `not`.

+ `getTokens` and `getDataSet` are private methods which have tokens and datasets.

+ Tokens can be received from `getTokens` method.
+ Other datasets can be received from `getDataSet` method.

This example demonstrates the usage of `Php Sentiment Analysis`,

  ```php
    Sentiment::make()->analyze('She is kind, but she hates others..');
  ```

  ```
    {
    "score": -1,
    "comparative": -0.14285714285714285,
    "calculation": [
    {"she": 0},{"is": 0},{"famous": 2},{"but": 0},{"she": 0},{"hates": -3},{"others": 0}
    ],
    "tokens": [
    "she","is","kind","but","she","hates","others"
    ],
    "positive": [
    "famous"
    ],
    "negative": [
    "hates"
    ]
    }
  ```

| Option         |  Description                                                                     |
|----------------|----------------------------------------------------------------------------------|
| `score`        |Positive or negative value after analysis of given statement.                           |
| `tokens`       |Tokens are the separated words in a Statement.                         |
| `comparative`  |Value received when score is divided by size of token.                                  |
| `calculation`   |Words in an array with a positive or negative value, if the word exists in `dataset` the value will be positive or negative otherwise value will be zero.                           |
| `positive`      |Shows all positive words from the statement if it has otherwise nothing is returned.         | 
| `negative`      |shows all negative words from the statement if it has otherwise nothing is returned.         | 

