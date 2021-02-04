DROP TABLE IF EXISTS `vtab_proveedores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`tpov1_user_views`@`%` SQL SECURITY DEFINER VIEW `vtab_proveedores`  AS  select `a`.`id_proveedor` AS `id_proveedor`,
`b`.`ejercicio` AS `ejercicio`,`a`.`nombre_razon_social` AS `nombre`,(select count(0) from `tab_contratos` `c` where 
((`a`.`id_proveedor` = `c`.`id_proveedor`) and (`c`.`id_ejercicio` = `b`.`id_ejercicio`) and (`c`.`id_contrato` > 1))) AS `contratos`,
(select count(0) from `tab_ordenes_compra` `f` where ((`a`.`id_proveedor` = `f`.`id_proveedor`) and (`f`.`id_ejercicio` = `b`.`id_ejercicio`) and 
(`f`.`id_orden_compra` > 1) and (`f`.`id_contrato` = 1))) AS `ordenes`,
(select ifnull(sum(`e`.`monto_desglose`),0) from (`tab_facturas` `d` join `tab_facturas_desglose` `e`) where ((`d`.`id_factura` = `e`.`id_factura`) 
and (`a`.`id_proveedor` = `d`.`id_proveedor`) and (`d`.`id_ejercicio` = `b`.`id_ejercicio`) and (`e`.`active` = 1) and (`d`.`active` = 1))) AS `monto` from 
(`tab_proveedores` `a` join `cat_ejercicios` `b`) having (`monto` <> 0) ;