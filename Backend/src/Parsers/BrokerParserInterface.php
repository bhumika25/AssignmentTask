<?php
interface BrokerParserInterface {
    public function parse(array $rows): array;
}
