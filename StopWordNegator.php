<?php

/**
 * StopWordNegator catchs stop words and even phrases that might be more than x words in
 * length
 */

/**
 * Store the content
 */
class ContentStore{

    /**
     * Type of Morderation required
     * @var int 
     */

    private $type;

    /**
     * Limit
     * @var int 
     */
    private $limit;

    /**
     * Label to be shown to the user
     * @var string 
     */
    private $label;

    /**
     * variable to be checked
     * @var string
     */
    private $var;

    public function __construct($type, $limit, $label, $var) {
        $this->type = $type;
        $this->limit = $limit;
        $this->label = $label;
        $this->var = $var;
    }
    
    public function getType() {
        return $this->type;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getVar() {
        return $this->var;
    }


};

/**
 * Main class
 */
class StopWordNegator{

    //CONSTANTS
    const TYPE_MODERATION_LEN = 0;
    const TYPE_MODERATION_WORD = 1;

    const MAX_LEN_PART_TITLE = 18;
    const MAX_LEN_SUBTITLE_APP_STORE = 30;
    const MAX_LEN_PROMOTION = 30;

    const MAX_LEN_MAIN_HASHTAG = 152;
    const MAX_LEN_MAIN_CONTENT = 1000;

    const MAX_WORDS_FEATURE_HEADING = 3;
    const MAX_LEN_FEATURE_DESC = 137;
    
    /**
     * To store the content & its type checks
     * @var ContentStore  
     */
    private $store = array();
    
    public function __construct() {
        $this->store = array();
    }

    /**
     * Queue content to tbe stored
     * @param type $type
     * @param type $limit
     * @param type $label
     * @param type $var
     */
    public function queue($type, $limit, $label, $var) {
            
        $contentItem = new ContentStore($type, $limit, $label, $var);
        $this->store[] = $contentItem;
    }
    
    /**
     * Run content moderator
     */

    public function run() {
        
        foreach ($this->store as $key) {
            
            $this->assertContent($key->getType(), $key->getLimit(), 
                                    $key->getLabel(), $key->getVar());
        }
    }

    //Function check whether content is word showing
    public function assertContent($type, $limit, $label, $var ){

        $failMsg = '';

        //https://gist.githubusercontent.com/brianteachman/4522951/raw/e3b03d167d216b99286a41603c107b7ea67711f9/stop_words.php
        $stopWords = array(
            'a',
            'about',
            'above',
            'after',
            'again',
            'against',
            'all',
            'am',
            'an',
            'and',
            'any',
            'are',
            "aren't",
            'as',
            'at',
            'be',
            'because',
            'been',
            'before',
            'being',
            'below',
            'between',
            'both',
            'but',
            'by',
            "can't",
            'cannot',
            'could',
            "couldn't",
            'did',
            "didn't",
            'do',
            'does',
            "doesn't",
            'doing',
            "don't",
            'down',
            'for',
            'from',
            'further',
            'had',
            "hadn't",
            'has',
            "hasn't",
            'have',
            "haven't",
            'having',
            'he',
            "he'd",
            "he'll",
            "help7",
            "he's",
            'her',
            'here',
            "here's",
            'hers',
            'herself',
            'him',
            'himself',
            'his',
            'how',
            "how's",
            'i',
            "i'd",
            "i'll",
            "i'm",
            "i've",
            'if',
            'in',
            'into',
            'is',
            "isn't",
            'it',
            "it's",
            'its',
            'itself',
            "let's",
            'me',
            'more',
            'most',
            "mustn't",
            'my',
            'myself',
            'no',
            'nor',
            'not',
            'of',
            'off',
            'on',
            'once',
            'only',
            'or',
            'other',
            'ought',
            'our',
            'ours',
            'ourselves',
            'out',
            'over',
            'own',
            'same',
            "shan't",
            'she',
            "she'd",
            "she'll",
            "she's",
            'should',
            "shouldn't",
            'so',
            'some',
            'such',
            'than',
            'that',
            "that's",
            'the',
            'their',
            'theirs',
            'them',
            'themselves',
            'then',
            'there',
            "there's",
            'these',
            'they',
            "they'd",
            "they'll",
            "they're",
            "they've",
            'this',
            'those',
            'through',
            'to',
            'too',
            'under',
            'until',
            'up',
            'very',
            'was',
            "wasn't",
            'we',
            "we'd",
            "we'll",
            "we're",
            "we've",
            'were',
            "weren't",
            'what',
            "what's",
            'when',
            "when's",
            'where',
            "where's",
            'which',
            'while',
            'who',
            "who's",
            'whom',
            'why',
            "why's",
            'w/',
            'with',
            "won't",
            'would',
            "wouldn't",
            'you',
            "you'd",
            "you'll",
            "you're",
            "you've",
            'your',
            'yours',
            'yourself',
            'yourselves',
            'zero'
        );
        

        $explodedVar = explode(" ", $var);

        //var_dump($explodedVar);

        foreach ($explodedVar as $term) {

            //Check for stop words
            foreach ($stopWords as $stopWord) {

                if(strtolower($term) == strtolower($stopWord)){
                    
                    echo $label.' ==> '.$stopWord;
                    echo "<br />==>".$var;
                    exit(0);
                }
            }
        }
        
        //Validate or word count
        if(StopWordNegator::TYPE_MODERATION_LEN == $type){
            
            if( strlen(htmlspecialchars_decode($var)) > $limit){
                echo $label.'['.$limit.']['.strlen(htmlspecialchars_decode($var)).']';
                echo "<br />==>".$var;
                exit(0);
            }
        }
        else if(StopWordNegator::TYPE_MODERATION_WORD == $type){ 
            
            if (str_word_count($var) > $limit){
                echo $label.'['.$limit.']['.str_word_count($var).']';
                echo "<br />==>".$var;
                exit(0);
            }
        }
        else{

            echo 'Wrong word/len limit check --->';
            echo $type." -- ".$limit." -- ".$label." -- ".$var;
            exit(0);
        }
    }
    
    /**
     * Desctructor
     */
    public function __destruct() {
        
        foreach ($this->store as $key) {
            $key = null;
        }
    }

}

?>