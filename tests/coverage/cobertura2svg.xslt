<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:variable name="covered" select="/coverage/@lines-covered" />
	<xsl:variable name="all" select="/coverage/@lines-valid" />
	<xsl:variable name="percentage" select="round($covered div $all * 100)" />
	<xsl:variable name="score">
		<xsl:choose>
			<xsl:when test="$percentage >= 90">high</xsl:when>
			<xsl:when test="$percentage >= 50">medium</xsl:when>
			<xsl:otherwise>low</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>

	<xsl:output encoding="utf-8"/>

	<xsl:template match="/">

		<svg xmlns="http://www.w3.org/2000/svg" width="104" height="20">
			<defs>
				<linearGradient id="label-fill" x1="50%" y1="0%" x2="50%" y2="100%">
					<stop stop-color="#444D56" offset="0%"></stop>
					<stop stop-color="#24292E" offset="100%"></stop>
				</linearGradient>
				<linearGradient id="value-fill-high" x1="50%" y1="0%" x2="50%" y2="100%">
					<stop stop-color="hsl(134, 62%, 41%)" offset="0%"></stop>
					<stop stop-color="hsl(134, 61%, 31%)" offset="100%"></stop>
				</linearGradient>
				<linearGradient id="value-fill-medium" x1="50%" y1="0%" x2="50%" y2="100%">
					<stop stop-color="hsl(28, 94%, 54%)" offset="0%"></stop>
					<stop stop-color="hsl(28, 93%, 44%)" offset="100%"></stop>
				</linearGradient>
				<linearGradient id="value-fill-low" x1="50%" y1="0%" x2="50%" y2="100%">
					<stop stop-color="hsl(354, 71%, 53%)" offset="0%"></stop>
					<stop stop-color="hsl(354, 70%, 43%)" offset="100%"></stop>
				</linearGradient>
				<mask id="rounded-corners">
					<rect x="0" y="0" width="104" height="20" fill="white" rx="3.5" />
				</mask>
			</defs>

			<g fill="none" fill-rule="evenodd" font-family="&#39;DejaVu Sans&#39;,Verdana,sans-serif" font-size="11" mask="url(#rounded-corners)">

				<rect x="0" y="0" width="63" height="20" fill="url(#label-fill)" fill-rule="nonzero"/>
				<text fill="#010101" fill-opacity=".3">
					<tspan x="7" y="15">coverage</tspan>
				</text>
				<text fill="#FFFFFF">
					<tspan x="6" y="14">coverage</tspan>
				</text>

				<g transform="translate(63, 0)">
					<rect x="0" y="0" width="41" height="20" fill="url(#value-fill-{$score})" fill-rule="nonzero"/>
					<text fill="#010101" fill-opacity=".3">
						<tspan x="6" y="15"><xsl:value-of select="$percentage"/>%</tspan>
					</text>
					<text fill="#FFFFFF">
						<tspan x="5" y="14"><xsl:value-of select="$percentage"/>%</tspan>
					</text>
				</g>

			</g>
		</svg>

	</xsl:template>

</xsl:stylesheet>
