import { handleResponsiveSwitch, withKeys } from '../helpers'
import { typographyOption } from './typography'
import { handleBackgroundOptionFor } from './background'

import { getWooGeneralVariablesFor } from './woocommerce/general'
import { getWooArchiveVariablesFor } from './woocommerce/archive'
import { getWooSingleGeneralVariablesFor } from './woocommerce/single-general'
import { getWooSingleGalleryVariablesFor } from './woocommerce/single-product-gallery'
import { getWooSingleLayersVariablesFor } from './woocommerce/single-product-layers'
import { getWooWishlistVariablesFor } from './woocommerce/wishlist'

export const getWooVariablesFor = () => ({
	...getWooGeneralVariablesFor(),
	...getWooArchiveVariablesFor(),
	...getWooSingleGeneralVariablesFor(),
	...getWooSingleGalleryVariablesFor(),
	...getWooSingleLayersVariablesFor(),
	...getWooWishlistVariablesFor(),
})
