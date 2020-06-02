<?php

namespace OTIFSolutions\PhpSentimentAnalysis;

class Sentiment
{

    private function getTokens($value){
        $tokens = explode(" ",
            trim(
                preg_replace('!\s+!', ' ',
                    preg_replace("/[^A-Za-z0-9\-]/"," ",
                        str_replace("\n"," ",
                            strtolower($value)
                        )
                    )
                )
            )
        );
        return $tokens;
    }

    private function getDataSet(){

        $labels = json_decode(file_get_contents("english_labels.json"),true);
        $emojis = json_decode(file_get_contents("emoji.json"),true);
        $dataSet['labels'] = array_merge($labels, $emojis);
        $dataSet['negators'] = json_decode(file_get_contents("negators.json"), true);

        return $dataSet;
    }

    public function analyze($value){

        $dataSet = $this->getDataSet();
        $tokens = $this->getTokens($value);
        $length = count($tokens);

        $score = 0;
        $skip = false;
        $words = [];
        $positive = [];
        $negative = [];
        $calculation = [];
        foreach ($tokens as $i => $token){
            if($skip) {
                $skip = false;
                continue;
            }
            if(($length-1) > $i){
                $combine = $token.' '.$tokens[$i+1];
                if(isset($dataSet['labels'][$combine])){
                    $tokenScore = $dataSet['labels'][$combine];
                    $skip = true;
                    $token = $combine;
                }
            }
            $words[] = $token;
            if(!$skip){
                $tokenScore = isset($dataSet['labels'][$token])? $dataSet['labels'][$token] : 0;
                if ($i > 0) {
                    $prevtoken = $tokens[$i - 1];
                    if (isset($dataSet['negators'][$prevtoken])) {
                        $tokenScore = -$tokenScore;
                    }
                }
            }
            if ($tokenScore > 0) $positive[] = $token;
            if ($tokenScore < 0) $negative[] = $token;
            $score += $tokenScore;
            $calculation[] = [ $token => $tokenScore ];
        }

        return json_encode([
            'score' => $score,
            'comparative' => sizeof($tokens) > 0 ? $score / sizeof($tokens) : 0,
            'calculation' => $calculation,
            'tokens' => $tokens,
            'words' => $words,
            'positive' => $positive,
            'negative' => $negative
        ]);
    }

}
