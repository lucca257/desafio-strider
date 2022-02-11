<?php

namespace App\Domain\Post\actions;

class IndentifyUserMentionAction
{
    public function execute(string $content)
    {
        $mentions = [];
        preg_match_all('/{User}(.*?){\/User}/s', $content, $mentions);
        if(empty($mentions[1])){
            return false;
        }
        return $mentions[1];
    }
}
