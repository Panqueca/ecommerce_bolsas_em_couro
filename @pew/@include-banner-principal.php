<style>
    .display-banner{
        margin-top: 0px;
        position: relative;
        width: 100%;
        background-color: #eee;
        height: 400px;
        overflow: hidden;
    }
    .display-banner .box-banner{
        position: absolute;
        width: 100%;
        top: 0px;
        left: 0px;
        transition: .6s ease-in;
        z-index: 1;
    }
    .display-banner .box-banner-ativo{
        left: 0px;
        z-index: 20;
    }
    .display-banner .box-banner-esquerda{
        left: 100%;
        z-index: 19;
    }
    .display-banner .box-banner-direita{
        left: -100%;
        z-index: 19;
    }
    .display-banner .box-banner .imagem-banner{
        width: 100%;
    }
    .display-banner .controller-banner{
        position: absolute;
        width: 100%;
        height: 30px;
        bottom: 20px;
        display: flex;
        justify-content: center;
        z-index: 21;
    }
    .display-banner .controller-banner .indice-banner{
        width: 8px;
        height: 8px;
        border: 3px solid #fff;
        margin: 5px;
        margin-left: 3px;
        margin-right: 3px;
        background-color: transparent;
        border-radius: 50%;
        cursor: pointer;
        transition: .3s;
        float: left;
    }
    .display-banner .controller-banner .indice-ativo{
        background-color: #fff;
        width: 8px;
        height: 8px;
        border: 4px solid #fff;
    }
</style>
<script>
    $(document).ready(function(){
        var statusDisplay = false;
        var transicaoAtiva = false;
        var defaultTimerDisplay = 5000;
        var ctrlTimerDisplay = defaultTimerDisplay;
        var quantidadeBanners = 0;
        var bannerAtivo = null;
        var bannerAnterior = null;
        var defaultBannerStringId = "banner_home_principal_";
        var defaultIndiceStringId = "indice_banner_";
        var defaultClassBannerAtivo = "box-banner-ativo";
        var defaultClassBannerEsquerda = "box-banner-esquerda";
        var defaultClassBannerDireita = "box-banner-direita";
        var defaultAnimationTime = 600;
        var defaultPosInicial = 1;
        var defaultPosFinal = quantidadeBanners;
        function setDisplay(){
            quantidadeBanners = $("#quantidade-banners").val();
            if(quantidadeBanners > 0){
                bannerAtivo = $("#"+defaultBannerStringId+defaultPosInicial);
                if(!bannerAtivo.hasClass(defaultClassBannerAtivo)){
                    bannerAtivo.addClass(defaultClassBannerAtivo);
                }
                function setHeight(){
                    bannerAnterior = $("#"+defaultBannerStringId+defaultPosFinal);
                    var heightBanner = bannerAtivo.css("height");
                    $(".display-banner").css("height", heightBanner);
                    if(heightBanner.replace("px", "") <= 200){
                        setTimeout(function(){
                            setHeight();
                        }, 200);
                    }else{
                        statusDisplay = true;
                        timerDisplay();
                    }
                }
                setHeight();
            }
        }
        setDisplay();

        function timerDisplay(){
            if(statusDisplay && quantidadeBanners > 1){
                var defaultDecrease = 500;
                function verificar(){
                    var mudarBanner = ctrlTimerDisplay <= 0 ? true : false;
                    if(mudarBanner){
                        transicaoBanner("next");
                    }else{
                        ctrlTimerDisplay -= defaultDecrease;
                    }
                }
                setInterval(function(){
                    if(transicaoAtiva == false){
                        verificar();
                    }
                }, defaultDecrease);
            }
        }

        function transicaoBanner(posicao){
            transicaoAtiva = true;
            var bannerSelecionado, bannerTrocado;
            var indiceSelecionado, indiceTrocado;
            var posBannerSelecionado, posBannerTrocado;
            posBannerTrocado = bannerAtivo.prop("id").replace(defaultBannerStringId, "");
            if(posicao == "next"){
                posBannerSelecionado = parseInt(posBannerTrocado) + 1 <= quantidadeBanners ? parseInt(posBannerTrocado) + 1 : defaultPosInicial;
            }else{
                posicao = parseInt(posicao);
                posBannerSelecionado = posicao;
            }
            bannerSelecionado = defaultBannerStringId+posBannerSelecionado;
            bannerTrocado = defaultBannerStringId+posBannerTrocado;
            indiceSelecionado = defaultIndiceStringId+posBannerSelecionado;
            indiceTrocado = defaultIndiceStringId+posBannerTrocado;
            $("#"+indiceSelecionado).addClass("indice-ativo");
            $("#"+indiceTrocado).removeClass("indice-ativo");
            bannerAtivo = $("#"+bannerSelecionado);
            bannerAnterior = $("#"+bannerTrocado);
            bannerAtivo.removeClass(defaultClassBannerEsquerda).addClass(defaultClassBannerAtivo);
            bannerAnterior.removeClass(defaultClassBannerAtivo).addClass(defaultClassBannerDireita);
            setTimeout(function(){
                bannerAnterior.css("transition", "0s");
                bannerAnterior.addClass(defaultClassBannerEsquerda).removeClass(defaultClassBannerDireita);
                var adjustDelay = 320;
                setTimeout(function(){
                    var transition = parseInt(defaultAnimationTime)/100;
                    bannerAnterior.css("transition", "."+transition+"s ease-in");
                    ctrlTimerDisplay = defaultTimerDisplay;
                    transicaoAtiva = false;
                }, adjustDelay);
            }, defaultAnimationTime);
        }
        $(".controller-banner .indice-banner").each(function(){
            var posicaoTarget = $(this).prop("id").replace(defaultIndiceStringId, "");
            $(this).off().on("click", function(){
                var posicaoBannerAtivo = bannerAtivo.prop("id").replace(defaultBannerStringId, "");
                if(transicaoAtiva == false && posicaoTarget != posicaoBannerAtivo){
                    transicaoBanner(posicaoTarget);
                }
            });
        });
    });
</script>
<?php
    require_once "@pew/pew-system-config.php";
    $tabela_banners = $pew_db->tabela_banners;
    $contarBanners = mysqli_query($conexao, "select count(id) as total_banners from $tabela_banners where status = 1");
    $contagemBanners = mysqli_fetch_assoc($contarBanners);
    $quantidadeBanners = $contagemBanners["total_banners"];
    if($quantidadeBanners > 0){
        echo "<section class='display-banner'>";
            $queryBanners = mysqli_query($conexao, "select * from $tabela_banners where status = 1 order by posicao asc");
            $ctrlQtdBanners = 0;
            while($banner = mysqli_fetch_array($queryBanners)){
                $titulo = $banner["titulo"];
                $descricao = $banner["descricao"];
                $imagem = $banner["imagem"];
                $dirImg = "imagens/banners/$imagem";
                $url = $banner["link"];
                $ctrlQtdBanners++;
                $posicao = $ctrlQtdBanners;
                $idBanner = "banner_home_principal_$posicao";
                $class = $posicao == 1 ? "box-banner-ativo": "box-banner-esquerda";
                echo "<div class='box-banner $class' id='$idBanner'>";
                    echo "<a href='$url'><img src='$dirImg' alt='$descricao' title='$titulo' class='imagem-banner'></a>";
                echo "</div>";
            }
            echo "<div class='controller-banner'>";
                for($i = 1; $i <= $ctrlQtdBanners; $i++){
                    $idIndice = "indice_banner_$i";
                    $classIndice = $i == 1 ? "indice-ativo" : "";
                    echo "<div class='indice-banner $classIndice' id='$idIndice'></div>";
                }
                echo "<input type='hidden' id='quantidade-banners' value='$ctrlQtdBanners'>";
            echo "</div>";
        echo "</section>";
    }
?>
