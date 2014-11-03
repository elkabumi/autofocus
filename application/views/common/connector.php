<beans xmlns="http://www.springframework.org/schema/beans"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.springframework.org/schema/beans http://www.springframework.org/schema/beans/spring-beans-3.0.xsd">

<bean id="Pacon" class="id.co.teramedia.tool.report.ParamConnector">
	<property name="paramString">
		<map>
			<?php foreach($list['paramString'] as $item) : ?>
			<entry key="<?=$item['key']?>" value="<?=$item['value']?>" />
			<?php endforeach; ?>
		</map>
	</property>
	<property name="paramInteger">
		<map>
			<?php foreach($list['paramInteger'] as $item) : ?>
			<entry key="<?=$item['key']?>" value="<?=$item['value']?>" />
			<?php endforeach; ?>

		</map>
	</property>
	<property name="paramDate">
		<map>
			<?php foreach($list['paramDate'] as $item) : ?>
			<entry key="<?=$item['key']?>" value="<?=$item['value']?>" />
			<?php endforeach; ?>
		</map>
	</property>
	<property name="paramNumeric">
		<map>
			<?php foreach($list['paramNumeric'] as $item) : ?>
			<entry key="<?=$item['key']?>" value="<?=$item['value']?>" />
			<?php endforeach; ?>
		</map>
	</property>
	<property name="paramSystem">
		<map>
			<?php foreach($list['paramSystem'] as $item) : ?>
			<entry key="<?=$item['key']?>" value="<?=$item['value']?>" />
			<?php endforeach; ?>
		</map>
	</property>

</bean>

</beans>
