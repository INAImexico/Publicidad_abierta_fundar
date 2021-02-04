--
-- Estructura para la vista `voc_monto_factura`
--
DROP TABLE IF EXISTS `voc_monto_factura`;

CREATE ALGORITHM=UNDEFINED DEFINER=`tpov1_user_views`@`%` SQL SECURITY DEFINER VIEW `voc_monto_factura`  AS  select `a`.`id_orden_compra` AS `id_orden_compra`,concat('$ ',convert(format(sum(`b`.`monto_desglose`),2) using utf8mb4)) AS `monto` from (`tab_facturas` `a` join `tab_facturas_desglose` `b`) where ((`a`.`id_factura` = `b`.`id_factura`) and (`a`.`active` = 1) and (`b`.`active` = 1)) group by `a`.`id_orden_compra`;


--
-- Estructura para la vista `voc_monto_factura_sf`
--
DROP TABLE IF EXISTS `voc_monto_factura_sf`;

CREATE ALGORITHM=UNDEFINED DEFINER=`tpov1_user_views`@`%` SQL SECURITY DEFINER VIEW `voc_monto_factura_sf`  AS  select `a`.`id_orden_compra` AS `id_orden_compra`,sum(`b`.`monto_desglose`) AS `monto` from (`tab_facturas` `a` join `tab_facturas_desglose` `b`) where ((`a`.`id_factura` = `b`.`id_factura`) and (`a`.`active` = 1) and (`b`.`active` = 1)) group by `a`.`id_orden_compra`;


--
-- Estructura para la vista `vmonto_oc`
--
DROP TABLE IF EXISTS `vmonto_oc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`tpov1_user_views`@`%` SQL SECURITY DEFINER VIEW `vmonto_oc`  AS  select `a`.`id_orden_compra` AS `id_orden_compra`,sum(`b`.`monto_desglose`) AS `monto` from (`tab_facturas` `a` join `tab_facturas_desglose` `b`) where ((`a`.`id_orden_compra` > 1) and (`a`.`id_factura` = `b`.`id_factura`) and (`a`.`active` = 1) and (`b`.`active` = 1)) group by `a`.`id_orden_compra`;