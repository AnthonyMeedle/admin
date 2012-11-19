<?php
		require_once("auth.php");
		$rsspass = new Variable("rsspass");
		$version = new Variable("version");
                $devise = ActionsDevises::instance()->get_devise_courante();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<?php require_once("title.php");?>
</head>

<?php
	require_once("../lib/magpierss/extlib/Snoopy.class.inc");
?>

<body>
<?php
	$menu="accueil";
        $breadcrumbs = Breadcrumb::getInstance()->getHomeList();
	require_once("entete.php");
?>

    <div class="row-fluid">
        <div class="span12">
            <h3>DASHBOARD</h3>
        </div>
    </div>
 <?php
	ActionsAdminModules::instance()->inclure_module_admin("accueil");


	$snoopy = new Snoopy();


	if($snoopy->fetch("http://thelia.net/version.php")){
		$versiondispo = trim($snoopy->results);
		if(! preg_match("/^[0-9.]*$/", $versiondispo))
			$versiondispo = "";
	}
	else{
		$versiondispo = "";
	}


 ?>
	<div class="row">
		<div class="span12">
		 <?php if(est_autorise("acces_commandes")){ ?>
                    <h3><?php echo trad('CA_30J', 'admin') ?></h3>
                    <div class="dashgraph">
			<div id="ca30j" style="height: 300px;"></div>
                    </div>
			<?php } ?>

		</div>
	</div>
	<div class="row-fluid spacetop18">
		<div class="span4">
			<h3>Informations site</h3>
                        <div class="littletable">
			<table class="table table-striped">
                            <?php $stat = new StatAdmin(); ?>
				<?php if(est_autorise("acces_clients")){ ?>
				<tr>
					<td><?php echo trad('Clients', 'admin'); ?></td>
                                        <td><?php echo $stat->getNbClient(); ?></td>
				</tr>
				<?php } ?>
				<?php if(est_autorise("acces_catalogue")){ ?>
				<tr>
					<td><?php echo trad('Rubriques', 'admin'); ?></td>
                                        <td><?php echo $stat->getNbCategory(); ?></td>
				</tr>
				<tr>
					<td><?php echo trad('Produits', 'admin'); ?></td>
                                        <td><?php echo $stat->getNbProduct(); ?></td>
				</tr>
				<tr>
					<td><?php echo trad('Produits_en_ligne', 'admin'); ?></td>
                                        <td><?php echo $stat->getNbProductOnLine(); ?></td>
				</tr>
				<tr>
					<td><?php echo trad('Produits_hors_ligne', 'admin'); ?></td>
                                        <td><?php echo $stat->getNbProductOffLine(); ?></td>
				</tr>
				<?php } ?>
				<?php if(est_autorise("acces_commandes")){ ?>
				<tr>
					<td><?php echo trad('Commandes', 'admin'); ?></td>
                                        <td><?php echo $stat->getNbCommand() ?></td>
				</tr>
				<tr>
					<td><?php echo trad('Commandes_en_instance', 'admin'); ?></td>
                                        <td><?php echo $stat->getNbCommandToBeProcess(); ?></td>
				</tr>
				<tr>
					<td><?php echo trad('Commandes_en_traitement', 'admin'); ?></td>
                                        <td><?php echo $stat->getNbCommandProcessed(); ?></td>
				</tr>
				<tr>
					<td><?php echo trad('Commandes_envoye', 'admin'); ?></td>
                                        <td><?php echo $stat->getNbCommandSend(); ?></td>
				</tr>
				<tr>
					<td><?php echo trad('Commandes_annulees', 'admin'); ?></td>
                                        <td><?php echo $stat->getNbCommandCanceled(); ?></td>
				</tr>
				<?php } ?>
                        </table>
                        </div>
		</div>
<?php if(est_autorise("acces_commandes")){ ?>
		<div class="span4">
			<h3>Statistiques de vente</h3>
			<ul class="nav nav-tabs" id="myTab">
				<li><a href="#statjour" data-toggle="tab">Aujourd'hui</a></li>
				<li class="active" ><a href="#statmois" data-toggle="tab">Ce mois</a></li>
				<li><a href="#statannee" data-toggle="tab">Cette ann&eacute;e</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane" id="statjour">
                                    <div class="littletable">
                                    <table class="table table-striped">
                                        <tr>
                                            <td><?php echo trad('CA_TTC','admin'); ?></td>
                                            <td><?php echo formatter_somme($stat->getTurnover('today')); ?> <?php echo $devise->symbole; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('CA_hors_frais_de_port','admin'); ?></td>
                                            <td><?php echo formatter_somme($stat->getTurnoverWithoutChippingPrice("today")); ?> <?php echo $devise->symbole; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('CA_PREC','admin'); ?></td>
                                            <td><?php echo formatter_somme($stat->getTurnover('yesterday')); ?> <?php echo $devise->symbole; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('Commandes_en_instance', 'admin'); ?></td>
                                            <td><?php echo $stat->getNbCommandToBeProcess("today"); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('Commandes_en_traitement', 'admin'); ?></td>
                                            <td><?php echo $stat->getNbCommandProcessed("year"); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('Commandes_annulees', 'admin'); ?></td>
                                            <td><?php echo $stat->getNbCommandCanceled("today"); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('Panier_moyen','admin'); ?></td>
                                            <td><?php echo formatter_somme($stat->getAverageCart("today")); ?> <?php echo $devise->symbole; ?></td>
                                        </tr>
                                    </table>
                                    </div>
                                </div>
				<div class="tab-pane active" id="statmois">
                                    <div class="littletable">
                                    <table class="table table-striped">
                                        <tr>
                                            <td><?php echo trad('CA_TTC','admin'); ?></td>
                                            <td><?php echo formatter_somme($stat->getTurnover('month')); ?> <?php echo $devise->symbole; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('CA_hors_frais_de_port','admin'); ?> <?php echo $devise->symbole; ?></td>
                                            <td><?php echo formatter_somme($stat->getTurnoverWithoutChippingPrice("month")); ?> <?php echo $devise->symbole; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('CA_PREC','admin'); ?></td>
                                            <td><?php echo formatter_somme($stat->getTurnover('lastmonth')); ?> <?php echo $devise->symbole; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('Commandes_en_instance', 'admin'); ?></td>
                                            <td><?php echo $stat->getNbCommandToBeProcess("month"); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('Commandes_en_traitement', 'admin'); ?></td>
                                            <td><?php echo $stat->getNbCommandProcessed("month"); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('Commandes_annulees', 'admin'); ?></td>
                                            <td><?php echo $stat->getNbCommandCanceled("month"); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('Panier_moyen','admin'); ?></td>
                                            <td><?php echo formatter_somme($stat->getAverageCart("month")); ?> <?php echo $devise->symbole; ?></td>
                                        </tr>
                                    </table>
                                    </div>
				</div>
				<div class="tab-pane" id="statannee">
                                    <div class="littletable">
                                    <table class="table table-striped">
                                        <tr>
                                            <td><?php echo trad('CA_TTC','admin'); ?></td>
                                            <td><?php echo formatter_somme($stat->getTurnover('year')); ?> <?php echo $devise->symbole; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('CA_hors_frais_de_port','admin'); ?></td>
                                            <td><?php echo formatter_somme($stat->getTurnoverWithoutChippingPrice("year")); ?> <?php echo $devise->symbole; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('CA_PREC','admin'); ?></td>
                                            <td><?php echo formatter_somme($stat->getTurnover('lastyear')); ?> <?php echo $devise->symbole; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('Commandes_en_instance', 'admin'); ?></td>
                                            <td><?php echo $stat->getNbCommandToBeProcess("year"); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('Commandes_en_traitement', 'admin'); ?></td>
                                            <td><?php echo $stat->getNbCommandProcessed("year"); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('Commandes_annulees', 'admin'); ?></td>
                                            <td><?php echo $stat->getNbCommandCanceled("year"); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo trad('Panier_moyen','admin'); ?></td>
                                            <td><?php echo formatter_somme($stat->getAverageCart("year")); ?> <?php echo $devise->symbole; ?></td>
                                        </tr>
                                    </table>
                                    </div>
                                </div>
			</div>
		</div>
<?php } ?>
		<div class="span4">
			<h3>Informations Thelia</h3>
                        <div class="littletable">
			<table class="table table-striped">
				<tr>
					<td><?php echo trad('Version_en_cours', 'admin'); ?></td>
					<td>V<?php echo rtrim(preg_replace("/(.)/", "$1.", Variable::lire('version')), "."); ?></td>
				</tr>
				<?php if($versiondispo != "") {?>
				<tr>
					<td><?php echo trad('Derniere_version_disponible', 'admin'); ?></td>
					<td><a href="http://sourceforge.net/projects/thelia/files/latest/download?source=files">V<?php echo $versiondispo; ?></a></td>
				</tr>
				<?php } ?>
				<tr>
					<td><?php echo trad('Actualites', 'admin'); ?></td>
					<td><a href="http://thelia.net/blog" target="_blank"><?php echo trad('cliquer_ici', 'admin'); ?></a></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
			</table>
                        </div>
		</div>
	</div>
<?php require_once("pied.php");?>
<script src="js/highcharts/highcharts.js"></script>

<script type="text/javascript">
    <?php
        $detailsTrunover = $stat->getDetailTurnover('last30days');
        $days = "";
        $value = "";
        foreach($detailsTrunover as $turnover)
        {
            $days .= '"'.strftime("%d-%b",  strtotime($turnover["date"])).'",';
            $value .= $turnover["ca"].',';
        }
        $days = rtrim($days,",");
        $value = rtrim($value,",");
      ?>
    $(function(){
       var chart;
       $(document).ready(function(){
          chart = new Highcharts.Chart({
              chart : {
                   renderTo : "ca30j",
                   animation : false
              },
              title : {
                  text : ""
              },
              xAxis : {
                  categories : [<?php echo $days; ?>]
              },
              yAxis : {
                  title : {
                      text : ""
                  }
              },
              colors: [
                '#E9720F',
                '#4572A7',
                '#AA4643',
                '#89A54E',
                '#80699B',
                '#3D96AE',
                '#DB843D',
                '#92A8CD',
                '#A47D7C',
                '#B5CA92'
              ] ,
              tooltip : {
                  formatter : function(){
                      return this.x + ': '+this.y + '<?php echo $devise->symbole; ?>';
                  }
              },
              legend : {
                  enabled : false
              },
              plotOptions : {
                  series : {
                      lineWidth : 4,
                      marker : {
                          lineWidth : 2,
                          fillColor: '#FFFFFF',
                          lineColor: null
                      },
                      animation : false
                  }
              },
              series : [
                  {
                      data : [<?php echo $value; ?>]
                  }
              ]
          });
       });
    });
</script>   
</body>
</html>
