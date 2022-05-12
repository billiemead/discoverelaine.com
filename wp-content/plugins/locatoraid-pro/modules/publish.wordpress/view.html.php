<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$tag = 'locatoraid';
?>
<h2><?php echo HCM::__('Shortcode'); ?></h2>
<code class="hc-p2 hc-mt2">
[<?php echo $tag; ?>]
</code>

<h2><?php echo HCM::__('Shortcode Options'); ?></h2>

<ul class="hc-ml3">
	<li>
		<h3 class="hc-underline">layout</h3>
	</li>
	<li>
		<?php echo HCM::__('Defines the front end view layout.'); ?>
	</li>
	<li>
		<?php echo HCM::__('Default'); ?>: <em>"map|list"</em>
	</li>

	<li>
		<ul class="hc-ml3">
			<li>
				<ul>
					<li>
						<strong>map</strong>
					</li>
					<li class="hc-ml3">
						<?php echo HCM::__('Displays the map.'); ?>
					</li>
				</ul>
			</li>

			<li>
				<ul>
					<li>
						<strong>list</strong>
					</li>
					<li class="hc-ml3">
						<?php echo HCM::__('Displays the list of locations.'); ?>
					</li>
				</ul>
			</li>

			<li>
				<?php echo HCM::__('You can combine the map and the list together with either | or /. The | options means the map and the list will be placed horizontally side by side, the / option will render them vertically stacked one after one.'); ?>
			</li>
			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> layout="map|list"]
				</code>
			</li>
			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> layout="list|map"]
				</code>
			</li>
			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> layout="map/list"]
				</code>
			</li>
			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> layout="map"]
				</code>
			</li>
		</ul>
	</li>

	<li>
		<h3 class="hc-underline">where-*</h3>
	</li>
	<li>
		<?php echo HCM::__('These parameters lets you filter out the locations that are displayed on this page.'); ?>
	</li>
	<li>
		<em>where-country, where-state, where-city</em>
	</li>
	<li class="hc-p2">
		<code class="hc-p2">
		[<?php echo $tag; ?> where-state="TX"]
		</code>
	</li>
	<li class="hc-p2">
		<code class="hc-p2">
		[<?php echo $tag; ?> where-country="Canada"]
		</code>
	</li>

	<li>
		<?php echo HCM::__('To select multiple options, separate them with |.'); ?>
	</li>
	<li class="hc-p2">
		<code class="hc-p2">
		[<?php echo $tag; ?> where-state="TX|AZ|CO"]
		</code>
	</li>

	<li>
		<h3 class="hc-underline">where-product</h3>
	</li>
	<li>
		<?php echo HCM::__('This parameter lets you filter out the locations based on the products they offer. You will need to enter the product ID.'); ?>
	</li>
	<li class="hc-p2">
		<code class="hc-p2">
		[<?php echo $tag; ?> where-product="2"]
		</code>
	</li>

	<li>
		<?php echo HCM::__('To select multiple options, separate them with |.'); ?>
	</li>
	<li class="hc-p2">
		<code class="hc-p2">
		[<?php echo $tag; ?> where-product="2|4|9"]
		</code>
	</li>


	<li class="hc-mt3">
		<h3 class="hc-underline">start</h3>
		<ul class="hc-ml3">
			<li>
				<?php echo HCM::__('Provides a default search string.'); ?>
			</li>
			<li>
				<?php echo HCM::__('Default'); ?>: <em>""</em>
			</li>
			<li>
				<?php echo HCM::__('Set to "no" if you want to start with the search form only without default results.'); ?>
			</li>
			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> start="Wilmington, DE"]
				</code>
			</li>
			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> start="no"]
				</code>
			</li>
		</ul>
	</li>

	<li class="hc-mt3">
		<h3 class="hc-underline">map-start-address, map-start-zoom</h3>
		<ul class="hc-ml3">
			<li>
				<?php echo HCM::__('If the start parameter is set to "no", you can show a default map without search results yet.'); ?>
			</li>
			<li>
				<?php echo HCM::__('Default'); ?>: <em>None</em>
			</li>
			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> map-start-address="Helsinki" map-start-zoom="10"]
				</code>
			</li>
		</ul>
	</li>

	<li class="hc-mt3">
		<h3 class="hc-underline">limit</h3>
		<ul class="hc-ml3">
			<li>
				<?php echo HCM::__('Limits the number of returned search results.'); ?>
			</li>
			<li>
				<?php echo HCM::__('Default'); ?>: <em>100</em>
			</li>
			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> limit="50"]
				</code>
			</li>
		</ul>
	</li>

	<li class="hc-mt3">
		<h3 class="hc-underline">clustering</h3>
		<ul class="hc-ml3">
			<li>
				<?php echo HCM::__('Use marker clusters to display a large number of markers on a map. Set the minimum quantity of locations on the map to activate clustering.'); ?>
			</li>
			<li>
				<?php echo HCM::__('Default'); ?>: <em>none</em>
			</li>
			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> clustering="20"]
				</code>
			</li>
		</ul>
	</li>

	<li class="hc-mt3">
		<h3 class="hc-underline">radius</h3>
		<ul class="hc-ml3">
			<li>
				<?php echo HCM::__('Makes the system search within the specified radius (in km or miles, depending on your settings). You can supply several options separated by commas. If several options are given, then it first searches within the first option and gives the More Results link to search within the next radius option. If no matches are found within the largest radius, it shows No Results message.'); ?>
			</li>
			<li>
				<?php echo HCM::__('Default'); ?>: <em>10, 25, 50, 100, 200, 500</em>
			</li>
			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> radius="20, 100"]
				</code>
			</li>
		</ul>
	</li>

	<li class="hc-mt3">
		<h3 class="hc-underline">radius-select</h3>
		<ul class="hc-ml3">
			<li>
				<?php echo HCM::__('Displays a drop-down list to select a search radius option. Set to 1 to show, 0 to hide.'); ?>
			</li>
			<li>
				<?php echo HCM::__('Default'); ?>: <em>0</em>
			</li>
			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> radius-select="1"]
				</code>
			</li>
		</ul>
	</li>


	<li class="hc-mt3">
		<h3 class="hc-underline">group</h3>
		<ul class="hc-ml3">
			<li>
				<?php echo HCM::__('Group the returned search results.'); ?>
			</li>
			<li>
				<?php echo HCM::__('Possible options'); ?>: <em>country, state, city, zip</em>.
			</li>

			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> group="state"]
				</code>
			</li>
		</ul>
	</li>

	<li class="hc-mt3">
		<h3 class="hc-underline">sort</h3>
		<ul class="hc-ml3">
			<li>
				<?php echo HCM::__('Sort the returned search results.'); ?>
			</li>
			<li>
				<?php echo HCM::__('Possible options'); ?>: <em>name, name-reverse</em>.
			</li>
			<li>
				<?php echo HCM::__('If no option is given, the results are sorted by distance to the address that was searched for.'); ?>
			</li>

			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> sort="name"]
				</code>
			</li>
		</ul>
	</li>

	<li class="hc-mt3">
		<h3 class="hc-underline">map-style</h3>
		<ul class="hc-ml3">
			<li>
				<?php echo HCM::__('Define the "style" HTML attribute for the map.'); ?>
			</li>
			<li>
				<?php echo HCM::__('Default'); ?>: <em>"height: 400px; width: 100%;"</em>
			</li>

			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> map-style="height: 20em; width: 100%;"]
				</code>
			</li>
		</ul>
	</li>

	<li class="hc-mt3">
		<h3 class="hc-underline">list-style</h3>
		<ul class="hc-ml3">
			<li>
				<?php echo HCM::__('Define the "style" HTML attribute for the results list.'); ?>
			</li>
			<li>
				<?php echo HCM::__('Default'); ?>: <em>"height: 400px; overflow-y: scroll;"</em>
			</li>

			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> list-style="height: auto;"]
				</code>
			</li>
		</ul>
	</li>

	<li class="hc-mt3">
		<h3 class="hc-underline">id</h3>
		<ul class="hc-ml3">
			<li>
				<?php echo HCM::__('It displays just one location defined by its id.'); ?>
			</li>

			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> id="123"]
				</code>
			</li>
		</ul>
	</li>

	<li class="hc-mt3">
		<h3 class="hc-underline">search-bias-country</h3>
		<ul class="hc-ml3">
			<li>
				<?php echo HCM::__('It makes the map search prefer matches in the specified country.'); ?>
			</li>

			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> search-bias-country="finland"]
				</code>
			</li>
		</ul>
	</li>

	<li class="hc-mt3">
		<h3 class="hc-underline">locate</h3>
		<ul class="hc-ml3">
			<li>
				<?php echo HCM::__('It lets you make use of the visitor current location.'); ?>
			</li>

			<li>
				<ul>
					<li><em>1</em> - show Locate Me option</li>
					<li><em>auto</em> - automatically start trying to determine the visitor current location</li>
					<li><em>0</em> - disable</li>
				</ul>
			</li>

			<li>
				<?php echo HCM::__('Default'); ?>: <em>1</em>
			</li>

			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> locate="1"]
				</code>
			</li>
			<li class="hc-p2">
				<code class="hc-p2">
				[<?php echo $tag; ?> locate="auto"]
				</code>
			</li>
		</ul>
	</li>

</ul>

<h2><?php echo HCM::__('GET Override'); ?></h2>

<ul class="hc-ml3">
	<li>
		<?php echo HCM::__('Any of the above parameters can be overridden by GET URL parameters prefixed with "lctr-".'); ?>
	</li>

	<li class="hc-p2">
		<code class="hc-p2">
		http://www.yoursite.com/locator/?lctr-start=florida&lctr-radius=100
		</code>
	</li>
</ul>
