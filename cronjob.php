<?php
require_once realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'bootstrap.php';
// To delete expired pro membership
DeleteExpiredProMemebership();
// To delete expired boost me users in find-matches page
DeleteExpiredBoosts();
// To delete expired xVisits in Popularity page
DeleteExpiredXvisits();
// To delete expired xMatches in Popularity page
DeleteExpiredXmatches();
// To delete expired xLikes in Popularity page
DeleteExpiredXlikes();
// To delete expired spam warning
if($config->spam_warning == '1') {
    DeleteSpamWarning();
}
// To delete more than 1 month hot users
DeleteExpiredHotUsers();
// To Delete unconfirmed video
DeleteUnusedVideo();
// To send queue emails
SendQueueEmails();