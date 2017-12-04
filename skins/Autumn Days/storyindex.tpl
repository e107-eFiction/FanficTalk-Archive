<!-- INCLUDE BLOCK : header -->
<div class="gb-full"> 
	<h1>{title} by {author}</h1>
	<div align="right">{printicon} {printepub}</div>
	<div id="output">
	<div class="jumpmenu">{jumpmenu}</div>
	<div class="listbox">
	<b>Summary:</b> {summary}<br>
	<b>Rating:</b> {rating} [{reviews} - {numreviews}] {score} {featuredstory}<br>
	<b>Category:</b> {category}<br>
	<b>Characters:</b> {characters}<br>
	{classifications}
	<b>Challenge:</b> {challengelinks}<br> <b>Series:</b> {serieslinks}<br>
	<b>Chapters: </b> {numchapters} <b>Completed:</b> {completed} <br> 
	<b>Words:</b> {wordcount} <b>Reads:</b> {count}<br>
	<b>Published:</b> {published} <b>Updated:</b> {updated}
	</div>
	{adminlinks}<br>
	<div align="center">{addtofaves}</div>
	</div>
	
	<br><br>
	
	<!-- START BLOCK : storynotes -->
	<blockquote><i><b>Story Summary:</b></i> {storynotes}</blockquote>
	<!-- END BLOCK : storynotes -->
	<br><br>
	
	<!-- START BLOCK : storyindexblock -->
	<b>{chapternumber}.</b> {title} by {author} [{reviews} - {numreviews}] {ratingpics} ({wordcount} words)
	<br><i>{chapternotes}</i> {adminoptions}<br>
	<!-- END BLOCK : storyindexblock -->
	
	{storyend} {last_read}
	<div id="pagelinks"><div class="jumpmenu">{jumpmenu2}</div></div>
	<div class="respond">{roundrobin}</div>
	{reviewform}
</div>
<!-- INCLUDE BLOCK : footer -->