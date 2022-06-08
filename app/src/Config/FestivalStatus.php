<?php

namespace App\Config;

enum FestivalStatus :string {
    case Draft = "draft";
    case Published = "published";
    case Archived = "archived";
}
