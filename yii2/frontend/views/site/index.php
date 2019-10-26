<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
\frontend\assets\AppAsset::register($this);
?>
<div id="app" :class="{loading : this.$store.state.isLoading}">
    <router-view></router-view>
</div>