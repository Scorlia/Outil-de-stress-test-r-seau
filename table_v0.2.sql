CREATE TABLE `logs` (
  `id` int,
  `port` varchar(255),
  `type` varchar(255),
  `date` datetime
);

CREATE TABLE `tests` (
  `id` int,
  `nom` varchar(255),
  `p1` int,
  `p2` int,
  `p3` int
);

CREATE TABLE `param` (
  `id` int,
  `desc` varchar(255),
  `d1_start` int,
  `d2_start` int,
  `d3_start` int,
  `d1_end` int,
  `d2_end` int,
  `d3_end` int,
  `u1_start` int,
  `u2_start` int,
  `u3_start` int,
  `u1_end` int,
  `u2_end` int,
  `u3_end` int
);

ALTER TABLE `param` ADD FOREIGN KEY (`id`) REFERENCES `tests` (`id`);
