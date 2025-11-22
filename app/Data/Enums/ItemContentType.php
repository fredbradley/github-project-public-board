<?php

namespace App\Data\Enums;

enum ItemContentType: string
{
    case ISSUE = 'Issue';
    case PR = 'PullRequest';
    case DRAFT = 'DraftIssue';
}
