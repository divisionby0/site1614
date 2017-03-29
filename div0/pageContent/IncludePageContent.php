<?php

class IncludePageContent
{
    public function __construct($contentPath)
    {
        include $contentPath;
    }
}