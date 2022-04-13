# StopWordNegator
StopWordNegator catchs stop words and even phrases that might be more than x words in  length

Its simple & fun, it points out if there are stop words in your content or if you have crossed X limits of words in a sentence. 

Written in PHP, usage is as following: 

$stopWordNegator = new StopWordNegator();

//Check class definition for the options. TODO: Update with better comments post finding product market fit of my app :( :)
$stopWordNegator->queue(StopWordNegator::TYPE_MODERATION_LEN, StopWordNegator::MAX_LEN_PART_TITLE, "PART TITLE", $partTitle);
$stopWordNegator->queue(StopWordNegator::TYPE_MODERATION_LEN, StopWordNegator::MAX_LEN_MAIN_CONTENT, "MAIN CONTENT", $mainContent);
