<?php

use Illuminate\Database\Seeder;

class ZeroConfiguration extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pass = bcrypt('123456');
        \DB::statement("INSERT INTO `menus` VALUES (1,'Configurações','fa-cogs','config.index','1',NULL,'2018-02-09 19:34:08','2018-02-09 19:34:08',NULL),(2,'Usuários','fa-user','user.index','1',1,'2018-02-09 19:34:33','2018-02-09 19:34:33',NULL),(3,'Usuários - Create','fa-plus','user.create','0',2,'2018-02-09 19:34:33','2018-02-09 19:34:33',NULL),(4,'Usuários - Edit','fa-pencil','user.edit','0',2,'2018-02-09 19:34:33','2018-02-09 19:34:33',NULL),(5,'Usuários - Destroy','fa-trash','user.destroy','0',2,'2018-02-09 19:34:34','2018-02-09 19:34:34',NULL),(6,'Usuários - Store','fa-save','user.store','0',2,'2018-02-09 19:34:34','2018-02-09 19:34:34',NULL),(7,'Usuários - Update','fa-save','user.update','0',2,'2018-02-09 19:34:36','2018-02-09 19:34:36',NULL),(8,'Role','fa-key','role.index','1',1,'2018-02-09 19:34:52','2018-02-09 19:34:52',NULL),(9,'Role - Create','fa-plus','role.create','0',8,'2018-02-09 19:34:52','2018-02-09 19:34:52',NULL),(10,'Role - Edit','fa-pencil','role.edit','0',8,'2018-02-09 19:34:52','2018-02-09 19:34:52',NULL),(11,'Role - Destroy','fa-trash','role.destroy','0',8,'2018-02-09 19:34:53','2018-02-09 19:34:53',NULL),(12,'Role - Store','fa-save','role.store','0',8,'2018-02-09 19:34:53','2018-02-09 19:34:53',NULL),(13,'Role - Update','fa-save','role.update','0',8,'2018-02-09 19:34:53','2018-02-09 19:34:53',NULL),(14,'Menu','fa-th-large','menu.index','1',1,'2018-02-09 19:35:26','2018-02-09 19:35:26',NULL),(15,'Menu - Create','fa-plus','menu.create','0',14,'2018-02-09 19:35:26','2018-02-09 19:35:26',NULL),(16,'Menu - Edit','fa-pencil','menu.edit','0',14,'2018-02-09 19:35:26','2018-02-09 19:35:26',NULL),(17,'Menu - Destroy','fa-trash','menu.destroy','0',14,'2018-02-09 19:35:26','2018-02-09 19:35:26',NULL),(18,'Menu - Store','fa-save','menu.store','0',14,'2018-02-09 19:35:26','2018-02-09 19:35:26',NULL),(19,'Menu - Update','fa-save','menu.update','0',14,'2018-02-09 19:35:27','2018-02-09 19:35:27',NULL),(20, 'Gestão', 'fa-tachometer', 'gestao.index', '1', NULL, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (21, 'Notícias', 'fa-plus-circle', 'news.index', '1', 20, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (22, 'Visualizar', 'fa-eye', 'news.index', '1', 21, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (23, 'Visualizar - Create', 'fa-plus', 'news.create', '0', 22, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (24, 'Visualizar - Edit', 'fa-pencil', 'news.edit', '0', 22, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (25, 'Visualizar - Destroy', 'fa-trash', 'news.destroy', '0', 22, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (26, 'Visualizar - Store', 'fa-save', 'news.store', '0', 22, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (27, 'Visualizar - Update', 'fa-save', 'news.update', '0', 22, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (28, 'Categorias', 'fa-align-center', 'news-category.index', '1', 21, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (29, 'Categorias - Create', 'fa-plus', 'news-category.create', '0', 28, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (30, 'Categorias - Edit', 'fa-pencil', 'news-category.edit', '0', 28, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (31, 'Categorias - Destroy', 'fa-trash', 'news-category.destroy', '0', 28, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (32, 'Categorias - Store', 'fa-save', 'news-category.store', '0', 28, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (33, 'Categorias - Update', 'fa-save', 'news-category.update', '0', 28, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (34, 'Produtos', 'fa-product-hunt',  'products.index', '1', 20, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (35, 'Visualizar', 'fa-eye', 'products.index', '1', 34, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (36, 'Visualizar - Show', 'fa-eye', 'products.show', '0', 35, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (37, 'Visualizar - Create', 'fa-plus', 'products.create', '0', 35, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (38, 'Visualizar - Edit', 'fa-pencil', 'products.edit', '0', 35, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (39, 'Visualizar - Destroy', 'fa-trash', 'products.destroy', '0', 35, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (40, 'Visualizar - Store', 'fa-save', 'products.store', '0', 35, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (41, 'Visualizar - Update', 'fa-save', 'products.update', '0', 35, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (42, 'Categorias', 'fa-align-center', 'product-category.index', '1', 34, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (43, 'Categorias - Show', 'fa-eye', 'product-category.show', '0', 42, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (44, 'Categorias - Create', 'fa-plus', 'product-category.create', '0', 42, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (45, 'Categorias - Edit', 'fa-pencil', 'product-category.edit', '0', 42, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (46, 'Categorias - Destroy',  'fa-trash', 'product-category.destroy', '0', 42, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (47, 'Categorias - Store', 'fa-save', 'product-category.store', '0', 42, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (48, 'Categorias - Update', 'fa-save', 'product-category.update', '0', 42, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (49, 'Sub Categorias', 'fa-align-justify', 'product-sub-category.index', '1', 34, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (50, 'Sub Categorias - Show', 'fa-eye', 'product-sub-category.show', '0', 49, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (51, 'Sub Categorias - Create', 'fa-plus', 'product-sub-category.create', '0', 49, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (52, 'Sub Categorias - Edit', 'fa-pencil', 'product-sub-category.edit', '0', 49, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (53, 'Sub Categorias - Destroy', 'fa-trash', 'product-sub-category.destroy', '0', 49, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (54, 'Sub Categorias - Store', 'fa-save', 'product-sub-category.store', '0', 49, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (55, 'Sub Categorias - Update', 'fa-save', 'product-sub-category.update', '0', 49, '2018-04-18 20:22:38', '2018-04-18 21:37:11', NULL),
        (56, 'Aplicativo', 'fa-android', 'aplicativo.index', '1', NULL, '2018-04-24 21:51:36', '2018-04-24 21:51:36', NULL),
        (57, 'Usuários', 'fa-user', 'users-app.index', '1', 56, '2018-04-24 21:53:36', '2018-04-24 21:53:36', NULL),
        (58, 'Usuários - Show', 'fa-eye', 'users-app.show', '0', 57, '2018-04-24 21:53:36', '2018-04-24 21:53:36', NULL),
        (59, 'Usuários - Create', 'fa-plus', 'users-app.create', '0', 57, '2018-04-24 21:53:36', '2018-04-24 21:53:36', NULL),
        (60, 'Usuários - Edit', 'fa-pencil', 'users-app.edit', '0', 57, '2018-04-24 21:53:36', '2018-04-24 21:53:36', NULL),
        (61, 'Usuários - Destroy', 'fa-trash', 'users-app.destroy', '0', 57, '2018-04-24 21:53:36', '2018-04-24 21:53:36', NULL),
        (62, 'Usuários - Store', 'fa-save', 'users-app.store', '0', 57, '2018-04-24 21:53:36', '2018-04-24 21:53:36', NULL),
        (63, 'Usuários - Update', 'fa-save', 'users-app.update', '0', 57, '2018-04-24 21:53:37', '2018-04-24 21:53:37', NULL),
        (64, 'Banner', 'fa-image', 'banner.index', '1', 20, '2018-06-18 13:48:52', '2018-06-18 13:48:52', NULL),
        (65, 'Banner - Show', 'fa-eye', 'banner.show', '0', 64, '2018-06-18 13:48:52', '2018-06-18 13:48:52', NULL),
        (66, 'Banner - Create', 'fa-plus', 'banner.create', '0', 64, '2018-06-18 13:48:52', '2018-06-18 13:48:52', NULL),
        (67, 'Banner - Edit', 'fa-pencil', 'banner.edit', '0', 64, '2018-06-18 13:48:52', '2018-06-18 13:48:52', NULL),
        (68, 'Banner - Destroy', 'fa-trash', 'banner.destroy', '0', 64, '2018-06-18 13:48:52', '2018-06-18 13:48:52', NULL),
        (69, 'Banner - Store', 'fa-save', 'banner.store', '0', 64, '2018-06-18 13:48:52', '2018-06-18 13:48:52', NULL),
        (70, 'Banner - Update', 'fa-save', 'banner.update', '0', 64, '2018-06-18 13:48:52', '2018-06-18 13:48:52', NULL),
        (71, 'Lojas', 'fa-shopping-cart', 'store.index', '1', 20, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (72, 'Lojas - Show', 'fa-eye', 'store.show', '0', 71, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (73, 'Lojas - Create', 'fa-plus', 'store.create', '0', 71, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (74, 'Lojas - Edit', 'fa-pencil', 'store.edit', '0', 71, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (75, 'Lojas - Destroy', 'fa-trash', 'store.destroy', '0', 71, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (76, 'Lojas - Store', 'fa-save', 'store.store', '0', 71, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (77, 'Lojas - Update', 'fa-save', 'store.update', '0', 71, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (78, 'Interesses', 'fa-bell', 'interests.index', '1', 20, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (79, 'Notificações', 'fa-bell', 'notifications.index', '1', 56, '2018-04-24 21:53:36', '2018-04-24 21:53:36', NULL),
        (80, 'Notificações - Show', 'fa-eye', 'notifications.show', '0', 79, '2018-04-24 21:53:36', '2018-04-24 21:53:36', NULL),
        (81, 'Notificações - Create', 'fa-plus', 'notifications.create', '0', 79, '2018-04-24 21:53:36', '2018-04-24 21:53:36', NULL),
        (82, 'Notificações - Edit', 'fa-pencil', 'notifications.edit', '0', 79, '2018-04-24 21:53:36', '2018-04-24 21:53:36', NULL),
        (83, 'Notificações - Destroy', 'fa-trash', 'notifications.destroy', '0', 79, '2018-04-24 21:53:36', '2018-04-24 21:53:36', NULL),
        (84, 'Notificações - Store', 'fa-save', 'notifications.store', '0', 79, '2018-04-24 21:53:36', '2018-04-24 21:53:36', NULL),
        (85, 'Notificações - Update', 'fa-save', 'notifications.update', '0', 79, '2018-04-24 21:53:37', '2018-04-24 21:53:37', NULL),
        (86, 'Planos', 'fa-tags', 'plan.index', '1', 20, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (87, 'Planos - Show', 'fa-eye', 'plan.show', '0', 86, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (88, 'Planos - Create', 'fa-plus', 'plan.create', '0', 86, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (89, 'Planos - Edit', 'fa-pencil', 'plan.edit', '0', 86, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (90, 'Planos - Destroy', 'fa-trash', 'plan.destroy', '0', 86, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (91, 'Planos - Store', 'fa-save', 'plan.store', '0', 86, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (92, 'Planos - Update', 'fa-save', 'plan.update', '0', 86, '2018-06-18 17:24:07', '2018-06-18 17:24:07', NULL),
        (93, 'Checkout', 'fa-credit-card', 'checkout.index', '1', NULL, '2019-05-30 16:03:12', '2019-05-30 16:04:47', NULL),
        (94, 'Checkout - Create', 'fa-plus', 'checkout.create', '0', '82', '2019-05-30 16:03:12', '2019-05-30 16:03:12', NULL),
        (95, 'Checkout - Show', 'fa-eye', 'checkout.show', '0', '82', '2019-05-30 16:03:12', '2019-05-30 16:03:12', NULL),
        (96, 'Checkout - Edit', 'fa-pencil-alt', 'checkout.edit', '0', '82', '2019-05-30 16:03:12', '2019-05-30 16:03:12', NULL),
        (97, 'Checkout - Destroy', 'fa-trash', 'checkout.destroy', '0', '82', '2019-05-30 16:03:12', '2019-05-30 16:03:12', NULL),
        (98, 'Checkout - Store', 'fa-save', 'checkout.store', '0', '82', '2019-05-30 16:03:12', '2019-05-30 16:03:12', NULL),
        (99, 'Checkout - Update', 'fa-save', 'checkout.update', '0', '82', '2019-05-30 16:03:12', '2019-05-30 16:03:12', NULL)
        ;");

        \DB::statement("INSERT INTO `roles` VALUES (1,'Administrador','2018-02-09 19:35:39','2018-02-09 19:35:39',NULL);");
        \DB::statement("INSERT INTO `permissions` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,19),(1, 20), (1, 21),(1, 22),(1, 23),(1, 24),(1, 25),(1, 26),(1, 27),(1, 28),(1, 29),(1, 30),(1, 31),(1, 32),(1, 33),(1, 34),(1, 35),(1, 36),(1, 37),(1, 38),(1, 39),(1, 40),(1, 41),(1, 42),(1, 43),(1, 44),(1, 45),(1, 46),(1, 47),(1, 48),(1, 49),(1, 50),(1, 51),(1, 52),(1, 53),(1, 54),(1, 55),(1, 56),(1, 57),(1, 58),(1, 59),(1, 60),(1, 61),(1, 62),(1, 63),(1, 64),(1, 65),(1, 66),(1, 67),(1, 68),(1, 69),(1, 70),(1, 71),(1, 72),(1, 73),(1, 74),(1, 75),(1, 76),(1, 77),(1, 78),(1, 79),(1, 80),(1, 81),(1, 82),(1, 83),(1, 84),(1, 85),(1, 86),(1, 87),(1, 88),(1, 89),(1, 90),(1, 91),(1, 92),(1, 93),(1, 94),(1, 95),(1, 96),(1, 97),(1, 98),(1, 99);");
        \DB::statement("INSERT INTO `users` VALUES (1,'admin@zordon.com.br', NULL, '$pass',NULL,NULL,'2018-02-09 19:36:57','2018-02-09 19:36:57',NULL);");
        \DB::statement("INSERT INTO `people` VALUES (1,'Zordon','1991-04-04','J',NULL, NULL, 1, NULL,1,'2018-02-09 19:36:57','2018-02-09 19:36:57',NULL);");
        \DB::statement("INSERT INTO `media_types` VALUES('1', 'image', 'pictures', 'png,jpg', '2018-04-06 14:48:43', '2018-04-06 14:48:43', NULL), ('2', 'application', 'pdfs', 'pdf', '2018-04-06 14:48:43', '2018-04-06 14:48:43', NULL), ('3', 'video', 'movies', 'mp4', '2018-04-06 14:48:43', '2018-04-06 14:48:43', NULL);");
        \DB::statement("INSERT INTO `countries` VALUES('1', 'Brasil', '2018-04-06 14:48:43', '2018-04-06 14:48:43', NULL)");
    }
}
