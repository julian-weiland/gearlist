<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header();

//$addGear = $_GET["addgear"];
//$removeGear = $_GET["removegear"];
//$removeGearSublist = $_GET["removegearsublist"];
//$gearSublist = $_GET["sublist"];

$permalinkmain = get_permalink();
$idmain = get_the_ID();

?>

<div class="row">
	<div class="small-12 medium-7 large-8 columns" role="main">

	<?php do_action( 'foundationpress_before_content' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
		</article>
	<?php endwhile;?>
		<div class="gearlist">
		<?php
			$allsublists = get_post_meta( get_the_ID(), 'sublists' ) ;
			$bodyWeight = 0; $consumerGoodsWeight = 0; $equipmentWeight = 0; $totalWeight = 0;//Set Statistics to 0;
			foreach ($allsublists as $singlesublist):
				$sublistoutput = sublistTable($idmain, $singlesublist, $permalinkmain, $allsublists);
				echo $sublistoutput['html'];
				$bodyWeight = $bodyWeight + $sublistoutput['bodyWeight'];
				$consumerGoodsWeight = $consumerGoodsWeight + $sublistoutput['consumerGoodsWeight'];
				$equipmentWeight = $equipmentWeight + $sublistoutput['equipmentWeight'];
				$totalWeight = $totalWeight + $sublistoutput['totalWeight'];
			endforeach;
		 ?>
		<?php
			echo "<div style='text-align:right; margin-right:40px'><strong >Gesamtgewicht: " . $totalWeight . "g</strong></div>";
		 ?>


		</div>
		
		<div class="columns small-12">
			<h3>Auswertung:</h3>
			<ul>
				<li>Gewicht am Körper: <?php echo $bodyWeight; ?>g</li>
				<li>Gewicht des Gepäcks: <?php echo $consumerGoodsWeight + $equipmentWeight; ?>g
					<ul>
						<li>Darin enthaltene Verbrauchsgüter: <?php echo $consumerGoodsWeight; ?>g</li>
						<li>Darin enthaltene Ausrüstung: <?php echo $equipmentWeight; ?>g</li>
					</ul>
				</li>
			</ul>
		</div>


	</div>

	<div class="addgearcontainer columns small-12 medium-3 large-4 hide-for-print">
		<div class="columns small-12">
			<h3>Vorhandenes Element hinzufügen:</h3>
		</div>

			<?php
			$geartype = get_terms( 'geartype', 'orderby=name&hide_empty=1' ); //Get all Geartype Taxonomie entries
			$totalgeartypecount = count($geartype);
			$geartypecount = 0;
			$endclass = '';
			foreach ($geartype as $geartypesingle) {
				$geartypecount++;
				if($totalgeartypecount == $geartypecount){$endclass = 'end';};
				echo '<div class="columns small-12 ' . $endclass . '">';
				echo $geartypesingle->name . '<br />';
				allGearByType($permalinkmain, $geartypesingle->slug, $allsublists);			//Get Gearoverview by Geartype Taxonomie
				echo "</div>";
			}
 ?>
	</div>

	
</div>
	<?php do_action( 'foundationpress_after_content' ); ?>

<?php get_footer(); ?>
