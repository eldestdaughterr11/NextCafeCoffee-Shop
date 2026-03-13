import { NextRequest, NextResponse } from 'next/server';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

export async function GET(req: NextRequest) {
  try {
    const { searchParams } = new URL(req.url);
    const email = searchParams.get('email');

    if (!email) {
      return NextResponse.json({ error: 'Email is required' }, { status: 400 });
    }

    // Find the user
    const user = await prisma.user.findUnique({
      where: { email: email },
      include: {
        orders: {
          include: {
            items: {
              include: {
                product: true
              }
            }
          }
        }
      }
    });

    if (!user) {
      return NextResponse.json({ error: 'User not found' }, { status: 404 });
    }

    const orders = user.orders;
    const totalOrders = orders.length;
    
    // Calculate total spent for points
    const totalSpent = orders.reduce((sum, order) => sum + Number(order.total), 0);
    const points = Math.floor(totalSpent / 50); // 1 point per ₱50 spent

    // Find favorite drink
    const drinkCounts: { [key: string]: { name: string, count: number } } = {};
    orders.forEach(order => {
      order.items.forEach(item => {
        if (item.product) {
          const prodId = item.productId.toString();
          if (!drinkCounts[prodId]) {
            drinkCounts[prodId] = { name: item.product.name, count: 0 };
          }
          drinkCounts[prodId].count += item.quantity;
        }
      });
    });

    let favoriteDrink = "None yet";
    let maxCount = 0;
    Object.values(drinkCounts).forEach(drink => {
      if (drink.count > maxCount) {
        maxCount = drink.count;
        favoriteDrink = drink.name;
      }
    });

    return NextResponse.json({
      totalOrders,
      points,
      favoriteDrink,
      totalSpent
    }, { status: 200 });

  } catch (error) {
    console.error('Stats Error:', error);
    return NextResponse.json({ error: 'Failed to fetch stats' }, { status: 500 });
  }
}
