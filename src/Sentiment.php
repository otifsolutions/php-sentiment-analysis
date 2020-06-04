<?php

namespace OTIFSolutions\PhpSentimentAnalysis;

/**
 * Class Sentiment
 * @package OTIFSolutions\PhpSentimentAnalysis
 */
class Sentiment
{

    /**
     * @param $value
     * @return array
     */
    private function getTokens($value){
        return explode(" ",
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
    }

    /**
     * @return array
     */
    private function getDataSet(){
        return [
            'labels' => array_merge(
                json_decode(file_get_contents(__DIR__ . "/english_labels.json"),true),
                json_decode(file_get_contents(__DIR__ . "/emoji.json"),true)
            ),
            'negators' => json_decode(file_get_contents(__DIR__ . "/negators.json"), true)
        ];
    }

    /**
     * @param $value
     * @return false|array
     */
    public function analyze($value){

        $dataSet = $this->getDataSet();
        $tokens = $this->getTokens($value);
        $length = count($tokens);

        $score = 0;
        $skip = false;
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

        return [
            'score' => $score,
            'comparative' => sizeof($tokens) > 0 ? $score / sizeof($tokens) : 0,
            'calculation' => $calculation,
            'tokens' => $tokens,
            'positive' => $positive,
            'negative' => $negative
        ];
    }

}
