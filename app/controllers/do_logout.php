<?php

namespace controllers;

session_start();
session_unset();

header('Location: ../../index.php');
exit();