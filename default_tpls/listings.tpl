<!-- START BLOCK : listings -->
{seriesheader}
<!-- START BLOCK : seriesblock -->
<div class="listbox {oddeven}  clearfix">
  <div class="gb-full">
    <hr class="style3">
    <br/>
    <h3>{title} {new} by {author}</h3>
    <div align="center">
      {numreviews} {reviews} &middot {score} likes
    </div><br/>
    <div align="center">{summary}</div><br/><br/>
  </div>
  <div class="gb-50">
    <b>Fandoms:</b> {category}</span><br/>
    <hr class="style2">
    <span class label="Characters"><b>Characters:</b> {characters}</span><br/>
    <hr class="style2">
    <span class label="Pairings"><b>Pairings:</b> {pairings}</span><br/>
  </div>
  <div class="gb-50">
    <span class label="Genre"><b>Genre:</b> {genre}</span><br/>
    <hr class="style2">
    <span class label="Themes"><b>Themes:</b> {themes}</span><br/>
    <hr class="style2">
    <span class label="Inclusivity"><b>Inclusivity:</b> {inclusivity}</span><br/>
  </div>
  <div class="gb-full">
    <br/>
    <div align="center"><b>Series Type:</b> {open} {comment} {roundrobin}<br />{adminoptions}</div>
      <div align="center">{adminlinks}</div><br/>
      <hr class="style2">
    	<br/><br/>
  </div>
</div><br/><br/>
<!-- END BLOCK : seriesblock -->

{stories}
<!-- START BLOCK : storyblock -->
<div class="listbox {oddeven} clearfix">
  <hr class="style3">
  <div class="gb-full">
    <h3>{featuredstory} {title} by {author}</h3>
  	<div align="right">{print} {printepub}</div>
  	<div id="output">
  		<div class="jumpmenu">{jumpmenu}</div>
  		<div class="listbox">
  			<div align="center">
  				<h7><b>Fandom: {category}</b> &middot	<b>Rating:</b> {rating} &middot {completed} <span class label="Story_Type">{Story_Type}</span><br/>
  				{numreviews} {reviews} &middot {score} likes &middot {count} reads</h7>
  			</div><br/><br/>
  		<blockquote2>{summary}</blockquote2><br/><br/>
      </div>
  	</div>
  </div>
  <div class="gb-50">
  	<span class label="Characters"><b>Characters:</b> {characters}</span><br/>
  	<hr class="style2">
  	<span class label="Pairings"><b>Pairings:</b> {pairings}</span><br/>
  	<hr class="style2">
  	<b>Story Length:</b> {numchapters} chapters ({wordcount} words)<br/>
  	<hr class="style2">
  	<span class label="Forum_House"><b>HPFT Forum House:</b> {forum_house}</span><br/>
    <hr class="style2">
  </div>
  <div class="gb-50">
  	<span class label="Genre"><b>Genre:</b> {genre}</span><br/>
  	<hr class="style2">
  	<span class label="Themes"><b>Themes:</b> {themes}</span><br/>
  	<hr class="style2">
  	<span class label="Inclusivity"><b>Inclusivity:</b> {inclusivity}</span><br/>
  	<hr class="style2">
  	<span class label="Advisories"><b>Advisories:</b> {advisories}</span>
    <hr class="style2">
  </div>
  <div class="gb-full">
  		<div align="center"><span class label="Series"><b>Series:</b> {serieslinks}</span></div>
      <br/>
  		<div align="center"><b>Published:</b> {published} &middot; <b>Updated:</b> {updated}</div>
      <div align="center"><h7>{last_read}</h7></div>
      <div align="center"><h7>{addtofaves}</h7> &middot; <h7>{tracker}</h7></div>
      <div align="center">{adminlinks}</div>
      <br/>
      <hr class="style2">
  </div>
  <br/>
</div>
<!-- END BLOCK : storyblock -->
{pagelinks}
<!-- END BLOCK : listings -->