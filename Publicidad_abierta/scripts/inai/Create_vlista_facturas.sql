DROP TABLE IF EXISTS `vlista_facturas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`tpov1_user_views`@`%` SQL SECURITY DEFINER VIEW `vlista_facturas`  AS  select `tab_facturas`.`id_factura` AS `id_factura`,
(select `c`.`ejercicio` from `cat_ejercicios` `c` where (`tab_facturas`.`id_ejercicio` = `c`.`id_ejercicio`)) AS `ejercicio`,(select `e`.`numero_contrato` 
from `tab_contratos` `e` where (`tab_facturas`.`id_contrato` = `e`.`id_contrato`)) AS `contrato`,(select `f`.`numero_orden_compra` from `tab_ordenes_compra` `f` 
where (`tab_facturas`.`id_orden_compra` = `f`.`id_orden_compra`)) AS `orden`,(select `d`.`trimestre` from `cat_trimestres` `d` 
where (`tab_facturas`.`id_trimestre` = `d`.`id_trimestre`)) AS `trimestre`,(select `d`.`nombre_razon_social` from `tab_proveedores` `d`
where (`tab_facturas`.`id_proveedor` = `d`.`id_proveedor`)) AS `proveedor`,`tab_facturas`.`numero_factura` AS `numero_factura`,
`tab_facturas`.`fecha_erogacion` AS `fecha_erogacion`,(select ifnull(sum(`i`.`monto_desglose`),0) from `tab_facturas_desglose` `i` 
where ((`tab_facturas`.`id_factura` = `i`.`id_factura`) and (`i`.`active` = 1) and (`tab_facturas`.`active` = 1))) AS `monto_factura`,
(select `g`.`name_active` from `sys_active` `g` where (`tab_facturas`.`active` = `g`.`id_active`)) AS `active` from `tab_facturas`;
