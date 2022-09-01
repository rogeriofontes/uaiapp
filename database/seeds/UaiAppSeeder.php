<?php

use Illuminate\Database\Seeder;

class UaiAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO `media` (`id`, `media`, `path`, `thumbnail_path`, `media_type_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (1, '3ae19688-33bf-48a1-af66-76b711635ebd.jpeg', 'pictures/Gj3rwg9wA8qJLyq0eJ2xHe1YeKoTJ8XkeAYW15PI.jpeg', 'pictures/e6d974d4fae099f3eaee59be8d40afa8.jpg', 1, '2018-04-18 12:47:08', '2018-04-18 12:47:08', NULL),
        (2, '3ae19688-33bf-48a1-af66-76b711635ebd.jpeg', 'pictures/hMhG2Cb9XF3aMrUxBgK6x21acml9OlI7jAJNxaXI.jpeg', 'pictures/e6d974d4fae099f3eaee59be8d40afa8.jpg', 1, '2018-04-18 12:47:46', '2018-04-18 12:47:46', NULL),
        (3, '3ae19688-33bf-48a1-af66-76b711635ebd.jpeg', 'pictures/3LDsn2M9fKTkP4htXyy1dI1FhjH61zNBNHdcgJVr.jpeg', 'pictures/e6d974d4fae099f3eaee59be8d40afa8.jpg', 1, '2018-04-18 12:47:52', '2018-04-18 12:47:52', NULL),
        (4, '3ae19688-33bf-48a1-af66-76b711635ebd.jpeg', 'pictures/HIJGgqp2sl4S8xy1uNBH2BFFVJjpTuqZ302LXwpH.jpeg', 'pictures/e6d974d4fae099f3eaee59be8d40afa8.jpg', 1, '2018-04-18 12:48:26', '2018-04-18 13:13:10', '2018-04-18 13:13:10'),
        (5, '01@2x (1).png', 'pictures/rw0KeuCiWhaupvRiUzRNze0U1Zxk57W0XVCNJ5nO.png', 'pictures/e7b5658fed61bf112cd12008d8794ddb.jpg', 1, '2018-04-18 13:13:10', '2018-04-18 14:17:32', '2018-04-18 14:17:32'),
        (6, '01@2x.png', 'pictures/2PoASz7qapZ4Eb7yu7296zyrazyTSF6UmkzbbDq6.png', 'pictures/c36c915055049f7791eb29d4f176edeb.jpg', 1, '2018-04-18 14:17:32', '2018-04-18 14:23:27', '2018-04-18 14:23:27'),
        (7, '5.jpg', 'pictures/n7VF60FxADFqFN3dwbgLeZQ5HnykXjQG4azOsfr5.jpeg', 'pictures/65b8207cd62094e5253189da6ff546f2.jpg', 1, '2018-04-18 14:23:27', '2018-04-18 14:23:27', NULL),
        (8, 'pexels-photo.jpg', 'pictures/Ctz4CZkxLRiRkr3EbddwQp1SMrSqPBPKZw3u4INz.jpeg', 'pictures/f259abc162e926f9d6f43790a6e810a1.jpg', 1, '2018-04-18 14:24:44', '2018-04-18 14:24:44', NULL),
        (9, 'dsc_0022.jpg', 'pictures/D6pl5JOLJlF02mKgtjrfYWZS62arjviNIclyygTG.jpeg', 'pictures/67615f5b61412fcdd4609dfd4f30301d.jpg', 1, '2018-04-18 14:26:10', '2018-04-18 14:26:10', NULL),
        (10, '1.jpg', 'pictures/rf36o18hmBfMxuU093cI6ecdW0B5DclkQ4dFSBjz.jpeg', 'pictures/25985ac6565ef97a5beb57a89cb53472.jpg', 1, '2018-04-22 23:57:57', '2018-04-23 13:47:54', '2018-04-23 13:47:54'),
        (11, '30428610.jpg', 'pictures/cj3FbHUmIFu7NQmMHnlSea0D7QfF4aVtYqic81UZ.jpeg', 'pictures/4faa5c7e3f8afac4c26deb01e1655465.jpg', 1, '2018-04-22 23:58:07', '2018-04-23 13:48:16', '2018-04-23 13:48:16'),
        (12, 'animais.png', 'pictures/asRJilL3Auoimp01vjacnR92lYKA1lAMGDn3SF0s.png', 'pictures/635553bd08029a3f89dbf49882fd0409.jpg', 1, '2018-04-23 13:47:54', '2018-04-23 13:47:54', NULL),
        (13, 'grao.png', 'pictures/EZ1bxJO2q4PfUdjFrw8vYDLhGUal93fLP3UKK7Qb.png', 'pictures/7164d569f1bfdb549dbf91affa56e40a.jpg', 1, '2018-04-23 13:48:16', '2018-04-23 13:48:16', NULL),
        (14, 'maquinas.png', 'pictures/xzgAZDvbGUsk4MW6iOqK55xRirqtYIdi45pDiOcf.png', 'pictures/d20382a328f8cb6097ba21db88092782.jpg', 1, '2018-04-23 13:48:33', '2018-04-23 13:48:33', NULL),
        (15, 'servicos.png', 'pictures/vQCdxy7EILyV1cZe1jneqAZPsx0XcW4FaZ3QU6et.png', 'pictures/1556a0bdedb2adb81acfd73f97d0300e.jpg', 1, '2018-04-23 13:48:46', '2018-04-23 13:48:46', NULL);
        ");

        \DB::statement("INSERT INTO `news_categories` (`id`, `category`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (1, 'Nova Categoria 2', '2018-04-18 03:01:36', '2018-04-18 03:06:30', NULL);");

        \DB::statement("INSERT INTO `news` (`id`, `date`, `title`, `subtitle`, `content`, `news_category_id`, `media_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (1, '2018-04-17', 'Imea eleva previsão de safra de milho em Mato Grosso', 'Volume colhido deve ficar próximo de 26 milhões de toneladas', 'Instituto Mato-grossense de Economia Agropecuária elevou sua estimativa de produção de milho do Estado na safra 2017/2018 para 25,91 milhões de toneladas, ante 24,74 milhões de toneladas da projeção anterior, divulgada em dezembro do ano passado. Somado ao estoque inicial na temporada, de 90 mil toneladas, o volume resulta em oferta de 25,99 milhões de toneladas no período, 2,13% acima do projetado no último boletim.\r\n\r\nA revisão foi publicada nesta segunda-feira (16/4), e se justifica \"por causa das condições climáticas mais favoráveis ao desenvolvimento das lavouras\", conforme o Imea. O instituto fez a ressalva, porém, de que em razão do menor investimento em tecnologia e da perspectiva de uma área plantada menor que na safrinha de 2016/2017, a oferta mato-grossense de milho em 2017/18 será 14,71% inferior à da temporada passada.\r\nA demanda pelo cereal do Estado projetada agora, de 25,89 milhões de toneladas, é 2,13% maior que a prevista em dezembro. Um dos motivos para o reajuste é a maior procura das usinas de etanol pelo produto do Estado, estimada pelo Imea em 5,23 milhões de toneladas na temporada.\r\n\r\nO número previsto para as exportações estaduais, de 15,68 milhões de toneladas, continua menor que o da safra passada em 22,84%, mas supera as 15,58 milhões de toneladas estimadas pelo Imea em seu último levantamento. Além disso, o instituto projeta vendas para outros Estados do País de 4,98 milhões de toneladas, acima das 4,53 milhões de toneladas no ciclo 2016/17.', 1, 7, '2018-04-18 12:48:26', '2018-04-18 14:23:32', NULL),
        (2, '2018-04-02', 'Saiba como tratar diarreia em galinhas', 'Má alimentação e vermes provocam diarreia em galinhas poedeiras', 'Em geral, aves que apresentam diarreia estão com problemas de alimentação. Em fase de postura, as galinhas devem receber ração adequada e água limpa e fresca. Para que tenham uma boa reprodução, é indicada a ração de postura, produto vendidos em lojas do varejo especializado. Como complemento, pode-se acrescentar milho na proporção de uma parte do grão para duas de ração. Forneça à vontade frutas e hortaliças cruas, exceto alface. A diarreia nas galinhas também pode ser causada devido à verminose, que ocorre devido à falta de vermifugação.\r\n', 1, 8, '2018-04-18 14:24:44', '2018-04-18 14:24:44', NULL),
        (3, '2018-04-17', 'Tempo ensolarado no Sul favorece atividades de campo', 'Região segue sem chuvas, assim como o Estado de São Paulo e parte do interior de Minas Gerais', 'O produtor da região Sul pode aproveitar os próximos dias para fazer suas atividades de campo. Isso porque a tendência vista nos últimos dias, de tempo seco e ensolarado, seguirá, segundo a previsão da Somar Meteorologia.\r\n\r\nO cenário também ocorrerá em outras áreas do país. O Estado de São Paulo, parte do interior de Minas Gerais e o interior da Bahia terão tempo aberto nos próximos dias. Já na faixa norte do país, as chuvas seguirão volumosas.', 1, 9, '2018-04-18 14:26:10', '2018-04-18 14:26:10', NULL);
        ");

        \DB::statement("INSERT INTO `product_categories` (`id`, `category`, `media_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
            (1, 'Animais', 12, '2018-04-22 23:57:57', '2018-04-23 13:47:54', NULL),
            (2, 'Grãos', 13, '2018-04-22 23:58:07', '2018-04-23 13:48:16', NULL),
            (3, 'Máquinas', 14, '2018-04-23 13:48:33', '2018-04-23 13:48:33', NULL),
            (4, 'Serviços', 15, '2018-04-23 13:48:46', '2018-04-23 13:48:46', NULL),
            (5, 'Lojas', 15, '2018-04-23 13:48:46', '2018-04-23 13:48:46', NULL),
            (6, 'Insumos', 15, '2018-04-23 13:48:46', '2018-04-23 13:48:46', NULL);
        ");

        \DB::statement("INSERT INTO `product_sub_categories` (`id`, `subcategory`, `product_category_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (4, 'Cavalos', 1, '2018-04-22 23:58:21', '2018-04-23 15:32:01', NULL),
        (5, 'Touros', 1, '2018-04-22 23:58:31', '2018-04-23 15:32:13', NULL),
        (6, 'Sub Categoria 2', 5, '2018-04-22 23:58:40', '2018-04-22 23:58:40', NULL),
        (7, 'Porcos', 1, '2018-04-23 15:32:23', '2018-04-23 15:32:23', NULL),
        (8, 'Galinhas', 1, '2018-04-23 15:32:34', '2018-04-23 15:32:34', NULL),
        (9, 'Vacas', 1, '2018-04-23 15:32:46', '2018-04-23 15:32:46', NULL),
        (10, 'Ovelhas', 1, '2018-04-23 15:32:56', '2018-04-23 15:32:56', NULL),
        (11, 'Cabras', 1, '2018-04-23 15:33:18', '2018-04-23 15:33:18', NULL),
        (12, 'Angola', 1, '2018-04-23 15:33:33', '2018-04-23 15:33:33', NULL),
        (13, 'Coelhos', 1, '2018-04-23 15:33:38', '2018-04-23 15:33:38', NULL),
        (14, 'Patos', 1, '2018-04-23 15:33:42', '2018-04-23 15:33:42', NULL);");

        

    }
}
