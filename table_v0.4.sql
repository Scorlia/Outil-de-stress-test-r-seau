CREATE TABLE `detail_logs` (
  `iddetail_logs` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `logs` bigint(20) NOT NULL,
  `port` int(11) NOT NULL,
  `up` int(11) NOT NULL,
  `down` int(11) NOT NULL,
  `ping` int(11) NOT NULL,
  `tiknum` int(11) NOT NULL,
  `test` int(11) NOT NULL
);

CREATE TABLE `port` (
  `idport` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nom` varchar(11) NOT NULL
);

CREATE TABLE `port_scenario` (
  `idport_scenario` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `port` int(11) DEFAULT NULL,
  `scenario` int(11) DEFAULT NULL,
  `numport` smallint(6) NOT NULL
);

CREATE TABLE `scenario` (
  `idscenario` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nom` varchar(11) NOT NULL,
  `intervalle` int(11) NOT NULL
);

CREATE TABLE `test` (
  `idtest` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `scenario` int(11) NOT NULL,
  `nom` varchar(11) NOT NULL,
  `ts_debut` datetime NOT NULL
);

CREATE TABLE `type_flux` (
  `code` varchar(2) PRIMARY KEY NOT NULL,
  `lib` varchar(16) NOT NULL
);

CREATE INDEX `port` ON `detail_logs` (`port`);

CREATE INDEX `test` ON `detail_logs` (`test`);

CREATE INDEX `port` ON `port_scenario` (`port`);

CREATE INDEX `scenario` ON `port_scenario` (`scenario`);

CREATE INDEX `scenario` ON `test` (`scenario`);

ALTER TABLE `detail_logs` ADD CONSTRAINT `detail_logs_ibfk_2` FOREIGN KEY (`port`) REFERENCES `port` (`idport`);

ALTER TABLE `detail_logs` ADD CONSTRAINT `details_logs_ibfk_1` FOREIGN KEY (`test`) REFERENCES `test` (`idtest`);

ALTER TABLE `port_scenario` ADD CONSTRAINT `port_scenario_ibfk_1` FOREIGN KEY (`port`) REFERENCES `port` (`idport`);

ALTER TABLE `port_scenario` ADD CONSTRAINT `port_scenario_ibfk_2` FOREIGN KEY (`scenario`) REFERENCES `scenario` (`idscenario`);

ALTER TABLE `test` ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`scenario`) REFERENCES `scenario` (`idscenario`);
