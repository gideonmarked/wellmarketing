<?php foreach ($news as $news_item): ?>
<div class="news-item fluid autocenter shadowed-box padded-box">
    <h2 class="title"><?php echo $news_item['title'] ?></h2>
    <?php if($news_item['image'] != ""): ?>
	    <img src="<?php echo base_url() . 'uploads/' . $news_item['image'] . '.jpg'; ?>">
	<?php endif; ?>
	<div class="mini-data">
		<?php echo $news_item['location'] ?>
		<?php echo $news_item['creation_timestamp'] ?>
	</div>
    <div class="content">
        <?php echo $news_item['content'] ?>
    </div>
    <!-- <p><a href="news/<?php echo $news_item['slug'] ?>">View article</a></p> -->
</div>
<?php endforeach ?>